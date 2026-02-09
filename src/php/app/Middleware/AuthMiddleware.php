<?php

namespace App\Middleware;

class AuthMiddleware implements Middleware
{
    /**
     * Ensure the user is logged in.
     * Redirects to the login page if not authenticated.
     */
    public function handle(): bool
    {
        if (!isset($_SESSION['loggedIn'])) {
            header('Location: /auth/login/');
            exit;
        }

        return true;
    }
}
