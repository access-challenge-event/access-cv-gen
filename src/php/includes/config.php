<?php
/**
 * Shared configuration and helper functions
 */

// Get environment variables
$app_env = getenv('APP_ENV') ?: 'development';

// Simple routing system
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'home';
$allowed_pages = ['home', 'create', 'my-cvs'];

// Default to home if invalid page
if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

// Helper function to check if current page is active
function is_active_page($page_name) {
    global $page;
    return $page === $page_name ? 'active' : '';
}

// Helper function to get page URL
function get_page_url($page_name) {
    return '?page=' . $page_name;
}

// Get page title
function get_page_title($page_name) {
    $titles = [
        'home' => 'Home',
        'create' => 'Create CV',
        'my-cvs' => 'My CVs'
    ];
    return isset($titles[$page_name]) ? $titles[$page_name] : 'Home';
}
?>
