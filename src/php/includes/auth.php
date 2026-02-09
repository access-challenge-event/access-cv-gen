<?php
/**
 * Authentication helper functions for Google OAuth
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoload Composer dependencies
require_once __DIR__ . '/../vendor/autoload.php';

use League\OAuth2\Client\Provider\Google;

/**
 * Get a PDO database connection (singleton)
 */
function get_db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $host = getenv('DB_HOST') ?: 'db';
        $name = getenv('DB_NAME') ?: 'cvgen';
        $user = getenv('DB_USER') ?: 'cvgen_user';
        $pass = getenv('DB_PASS') ?: 'cvgen_password';

        $pdo = new PDO(
            "mysql:host=$host;dbname=$name;charset=utf8mb4",
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }
    return $pdo;
}

/**
 * Get a configured Google OAuth provider instance
 */
function get_google_provider(): Google {
    return new Google([
        'clientId'     => getenv('GOOGLE_CLIENT_ID'),
        'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
        'redirectUri'  => 'http://localhost:8080/?page=callback',
    ]);
}

/**
 * Get the currently logged-in user, or null
 */
function get_current_user_data(): ?array {
    return $_SESSION['user'] ?? null;
}

/**
 * Check if the current user is logged in
 */
function is_logged_in(): bool {
    return isset($_SESSION['user']);
}

/**
 * Redirect to the login page if the user is not authenticated
 */
function require_login(): void {
    if (!is_logged_in()) {
        header('Location: ?page=login');
        exit;
    }
}

/**
 * Find or create a user from Google profile data.
 * Returns the user row as an associative array.
 */
function find_or_create_user(string $google_id, string $email, string $name, ?string $avatar_url): array {
    $db = get_db();

    // Try to find existing user
    $stmt = $db->prepare('SELECT * FROM users WHERE google_id = :google_id');
    $stmt->execute(['google_id' => $google_id]);
    $user = $stmt->fetch();

    if ($user) {
        // Update profile info on each login
        $stmt = $db->prepare(
            'UPDATE users SET email = :email, name = :name, avatar_url = :avatar_url WHERE google_id = :google_id'
        );
        $stmt->execute([
            'email'      => $email,
            'name'       => $name,
            'avatar_url' => $avatar_url,
            'google_id'  => $google_id,
        ]);
        $user['email'] = $email;
        $user['name'] = $name;
        $user['avatar_url'] = $avatar_url;
    } else {
        // Create new user
        $stmt = $db->prepare(
            'INSERT INTO users (google_id, email, name, avatar_url) VALUES (:google_id, :email, :name, :avatar_url)'
        );
        $stmt->execute([
            'google_id'  => $google_id,
            'email'      => $email,
            'name'       => $name,
            'avatar_url' => $avatar_url,
        ]);
        $user = [
            'id'         => $db->lastInsertId(),
            'google_id'  => $google_id,
            'email'      => $email,
            'name'       => $name,
            'avatar_url' => $avatar_url,
        ];
    }

    return $user;
}
