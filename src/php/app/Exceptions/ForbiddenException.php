<?php

namespace App\Exceptions;

class ForbiddenException extends \Exception
{
    public function __construct(string $message = 'You do not have permission to access this page.')
    {
        parent::__construct($message, 403);
    }
}
