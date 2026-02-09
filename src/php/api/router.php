<?php
/**
 * API Router
 *
 * Single entry point for all API requests.
 * Routes to the appropriate query handler based on the 'action' parameter.
 *
 * Usage: POST /api/router.php
 * Body: { "action": "grade_cv", "data": { ... } }
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

// Buffer output so fatal errors or accidental HTML output can be returned as JSON
ob_start();
register_shutdown_function(function () {
    $err = error_get_last();
    if ($err !== null) {
        http_response_code(500);
        header('Content-Type: application/json');
        // Discard any buffered output
        if (ob_get_length() !== false) {
            @ob_end_clean();
        }
        echo json_encode([
            'error' => 'Fatal PHP error',
            'detail' => $err['message'],
            'file' => $err['file'],
            'line' => $err['line']
        ]);
        return;
    }

    // No fatal error — flush buffered content, but inspect for unexpected HTML
    $content = '';
    if (ob_get_length() !== false) {
        $content = ob_get_clean();
    }
    $trim = ltrim($content);
    if ($trim !== '' && isset($trim[0]) && $trim[0] === '<') {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Unexpected HTML output from PHP',
            'detail' => substr($content, 0, 1000)
        ]);
        return;
    }

    // Normal output — print as originally intended
    echo $content;
});

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Load app config (session, auth, autoloader, db helpers)
require_once __DIR__ . '/../includes/config.php';

// Load API classes
require_once __DIR__ . '/../includes/api/DeepSeekClient.php';
require_once __DIR__ . '/../includes/api/InputSanitizer.php';
require_once __DIR__ . '/../includes/api/BaseQuery.php';

use CVGen\Api\DeepSeekClient;
use CVGen\Api\InputSanitizer;

// Parse JSON body
$rawBody = file_get_contents('php://input');
$body = json_decode($rawBody, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON body']);
    exit;
}

$action = $body['action'] ?? null;
$data = $body['data'] ?? [];

if (!$action) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required field: action']);
    exit;
}

// --- Query Registry ---
// To add a new query: create a class in includes/api/queries/ and add it here.
$queryMap = [
    'grade_cv'    => 'GradeCVQuery',
    'generate_cv' => 'GenerateCVQuery',
];

if (!isset($queryMap[$action])) {
    http_response_code(400);
    echo json_encode([
        'error' => "Unknown action: {$action}",
        'available_actions' => array_keys($queryMap),
    ]);
    exit;
}

$queryClass = $queryMap[$action];
$queryFile = __DIR__ . "/../includes/api/queries/{$queryClass}.php";

if (!file_exists($queryFile)) {
    http_response_code(500);
    echo json_encode(['error' => "Query handler not found for action: {$action}"]);
    exit;
}

require_once $queryFile;

$fqcn = "CVGen\\Api\\Queries\\{$queryClass}";

try {
    $ai = new DeepSeekClient();
    $sanitizer = new InputSanitizer();

    // TODO: Pass database connection once DB integration is ready
    // $db = get_db();

    /** @var \CVGen\Api\BaseQuery $query */
    $query = new $fqcn($ai, $sanitizer);

    $result = $query->execute($data);

    echo json_encode([
        'success' => true,
        'action'  => $action,
        'result'  => $result,
    ]);
} catch (\InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
} catch (\RuntimeException $e) {
    http_response_code(502);
    echo json_encode(['error' => 'AI service error', 'detail' => $e->getMessage()]);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
    error_log("API error [{$action}]: " . $e->getMessage());
}
