<?php

namespace App\Middleware;

interface Middleware
{
    /**
     * Handle the incoming request.
     * Should return true to allow the request to continue,
     * or redirect / exit to block it.
     */
    public function handle(): bool;
}
