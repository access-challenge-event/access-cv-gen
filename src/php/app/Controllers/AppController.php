<?php

namespace App\Controllers;

class AppController
{
    public function home() {
        return [
            'title' => 'Home',
            'template' => 'home.html.php',
            'vars' => []
        ];
    }

    public function create()
    {
        return [
            'title' => 'Create CV',
            'template' => 'create-cv.html.php',
            'vars' => []
        ];
    }
}