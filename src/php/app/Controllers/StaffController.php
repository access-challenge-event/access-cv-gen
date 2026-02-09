<?php

namespace App\Controllers;

class StaffController
{
    public function __construct() {}

    public function dashboard()
    {
        return [
            'title' => 'Dashboard',
            'template' => 'staff-dashboard.html.php',
            'vars' => []
        ];
    }
}