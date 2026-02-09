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
}

require_once 'includes/footer.php';

?>
