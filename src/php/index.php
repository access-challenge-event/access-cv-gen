<?php
/**
 * CV Generator - Main Application Entry Point
 * Routes requests to appropriate page content
 */

<<<<<<< HEAD
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/includes/config.php';

$entryPoint = new \App\EntryPoint(new \App\Routes());
$entryPoint->run();
=======
require_once 'includes/config.php';

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
>>>>>>> b97dd75 (feat: oauth semi working)
