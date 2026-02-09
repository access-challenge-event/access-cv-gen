<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 1fb05d977f9af7fd71a6dc807c62f882f8bcb615
<?php
/**
 * CV Generator - Main Application Entry Point
 * Routes requests to appropriate page content
 */

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/includes/config.php';

<<<<<<< HEAD
<<<<<<< HEAD
// Handle logout (no page render needed)
if ($page === 'logout') {
    session_destroy();
    header('Location: ?page=home');
    exit;
}

// Handle OAuth callback (redirects, no page render needed)
if ($page === 'callback') {
    require_once 'pages/callback.php';
    exit;
}

require_once 'includes/header.php';

// Include the appropriate page content
if ($page === 'home') {
    require_once 'pages/home.php';
} elseif ($page === 'create') {
    require_once 'pages/create.php';
} elseif ($page === 'my-cvs') {
    require_once 'pages/my-cvs.php';
} elseif ($page === 'login') {
    require_once 'pages/login.php';
}

require_once 'includes/footer.php';
=======
<?php
/**
 * CV Generator - Main Application Entry Point
 * Routes requests to appropriate page content
 */

require_once 'includes/config.php';
require_once 'includes/header.php';

// Include the appropriate page content
if ($page === 'home') {
    require_once 'pages/home.php';
} elseif ($page === 'create') {
    require_once 'pages/create.php';
} elseif ($page === 'my-cvs') {
    require_once 'pages/my-cvs.php';
} elseif ($page === 'my-account') {
    require_once 'pages/my-account.php';
} elseif ($page === 'upload-cv') {
    require_once 'pages/upload-cv.php';
}

require_once 'includes/footer.php';

?>
>>>>>>> f5d48be (add my-account and upload-cv pages; update routing and titles)
=======
$entryPoint = new \App\EntryPoint(new \App\Routes());
$entryPoint->run();
>>>>>>> fe6f1b2 (refactor: routing, autoloading and added basic MVC architecture)
=======
$entryPoint = new \App\EntryPoint(new \App\Routes());
$entryPoint->run();
>>>>>>> 1fb05d977f9af7fd71a6dc807c62f882f8bcb615
