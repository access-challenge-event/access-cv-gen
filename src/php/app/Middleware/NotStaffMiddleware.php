<?php

namespace App\Middleware;

use App\Exceptions\ForbiddenException;

class NotStaffMiddleware implements Middleware
{
    /**
     * Block staff members from accessing this route.
     * Throws ForbiddenException if the user has the 'staff' role.
     */
    public function handle(): bool
    {
        if (isset($_SESSION['loggedIn']['role']) && $_SESSION['loggedIn']['role'] === 'staff') {
            throw new ForbiddenException();
        }

        return true;
    }
}
