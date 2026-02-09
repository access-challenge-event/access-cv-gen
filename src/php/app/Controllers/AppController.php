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

    public function jobs()
    {
        $jobListings = [];
        $error = null;

        try {
            $stmt = $this->pdo->prepare(
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