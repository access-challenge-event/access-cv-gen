<?php

namespace App\Controllers;

class AppController
{
    public function __construct(
        private \PDO $pdo
    ) {}

    public function home() {
        // Test database connection
        $dbConnected = false;
        try {
            $stmt = $this->pdo->query('SELECT 1');
            $dbConnected = $stmt !== false;
        } catch (\Exception $e) {
            $dbConnected = false;
        }

        return [
            'title' => 'Home',
            'template' => 'home.html.php',
            'vars' => [
                'dbConnected' => $dbConnected
            ]
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