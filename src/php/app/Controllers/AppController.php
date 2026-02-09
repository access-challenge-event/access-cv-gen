<?php

namespace App\Controllers;

class AppController
{
    private function getPdo(): \PDO
    {
        $host = getenv('DB_HOST') ?: 'db';
        $dbName = getenv('DB_NAME') ?: 'cvgen';
        $user = getenv('DB_USER') ?: 'cvgen_user';
        $pass = getenv('DB_PASS') ?: 'cvgen_password';

        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $dbName);

        return new \PDO($dsn, $user, $pass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
    }

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

    public function jobs()
    {
        $jobListings = [];
        $error = null;

        try {
            $pdo = $this->getPdo();
            $stmt = $pdo->prepare(
                'SELECT job_id, title, company, location, employment_type, level, description, responsibilities, requirements, salary_range, posted_date
                 FROM job_listings
                 WHERE deleted = 0
                 ORDER BY posted_date DESC, job_id DESC'
            );
            $stmt->execute();
            $jobListings = $stmt->fetchAll();
        } catch (\Throwable $e) {
            $error = 'Unable to load job listings right now.';
        }

        return [
            'title' => 'Job Listings',
            'template' => 'job-listings.html.php',
            'vars' => [
                'jobListings' => $jobListings,
                'error' => $error,
            ]
        ];
    }
}