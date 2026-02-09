<?php
/**
 * Shared configuration and helper functions
 */

// Get environment variables
$app_env = getenv('APP_ENV') ?: 'development';

// Simple routing system (path-based)
$request_path = explode('?', ltrim($_SERVER['REQUEST_URI'] ?? '', '/'))[0];
$parts = array_values(array_filter(explode('/', $request_path), 'strlen'));
$page = $parts[1] ?? ($parts[0] ?? 'home');
$allowed_pages = ['home', 'create', 'my-cvs', 'jobs', 'login', 'logout', 'callback'];

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
    $routes = [
        'home' => '/app/home',
        'create' => '/app/create',
        'my-cvs' => '/app/my-cvs',
        'jobs' => '/app/jobs',
        'login' => '/auth/login',
        'logout' => '/auth/logout',
        'callback' => '/auth/callback',
    ];

    return $routes[$page_name] ?? '/app/home';
}

// Get page title
function get_page_title($page_name) {
    $titles = [
        'home' => 'Home',
        'create' => 'Create CV',
        'my-cvs' => 'My CVs',
        'jobs' => 'Job Listings',
        'login' => 'Login',
    ];
    return isset($titles[$page_name]) ? $titles[$page_name] : 'Home';
}
?>
