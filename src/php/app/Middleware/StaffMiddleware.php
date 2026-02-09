<?php

namespace App\Middleware;

use App\Exceptions\ForbiddenException;

class StaffMiddleware implements Middleware
{
    /**
     * Ensure the user is logged in AND has the 'staff' role.
     * Redirects to login if not authenticated.
     * Throws ForbiddenException if authenticated but not staff.
     */
    public function handle(): bool
    {
        if (!isset($_SESSION['loggedIn'])) {
            header('Location: /auth/login/');
            exit;
        }

        if (!isset($_SESSION['loggedIn']['role']) || $_SESSION['loggedIn']['role'] !== 'staff') {
            throw new ForbiddenException();
        }

        return true;
    }
}
