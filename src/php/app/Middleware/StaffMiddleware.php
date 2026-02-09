<?php

namespace App\Middleware;

class StaffMiddleware implements Middleware
{
    /**
     * Ensure the user is logged in AND has the 'staff' role.
     * Redirects to login if not authenticated, or to home if not staff.
     */
    public function handle(): bool
    {
        if (!isset($_SESSION['loggedIn'])) {
            header('Location: /auth/login/');
            exit;
        }

        if (!isset($_SESSION['loggedIn']['role']) || $_SESSION['loggedIn']['role'] !== 'staff') {
            header('Location: /');
            exit;
        }

        return true;
    }
}
