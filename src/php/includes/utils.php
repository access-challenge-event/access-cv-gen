<?php

function quick_date(string $format = 'Y-m-d H:i:s') {
    $date = new \DateTime();
    return $date->format($format);
}

function set_session_login(array $user) {
    if (!$user) { return; }

    $_SESSION['loggedIn'] = [
        'id' => $user['user_id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'role' => $user['role'] ?? null
    ];
}

function redirect(string $location = "/article/home/") {
    header('location: ' . $location);
    exit;
}

function login_check() {
    if (!isset($_SESSION['loggedIn'])) {
        redirect('/auth/login/');
    }
}

function is_logged_in() {
    return isset($_SESSION['loggedIn']);
}

function login($user) {
    $_SESSION['loggedIn'] = [
        'id' => $user['user_id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'role' => $user['role'] ?? null
    ];
}

function get_current_user_data() {
    if (isset($_SESSION['loggedIn'])) {
        return [
            'name' => $_SESSION['loggedIn']['username'] ?? 'User',
        ];
    }

    return [
        'name' => 'Guest',
    ];
}
