<?php

namespace App\Controllers;

use Classes\DatabaseTable;

class StaffController extends Controller
{
    public function __construct(
        public \PDO $pdo,
        public DatabaseTable $userTable,
    ) {}

    private function formatSalaryRange(string $min, string $max): ?string
    {
        $min = (int) $min;
        $max = (int) $max;
        if ($min <= 0 && $max <= 0) return null;
        if ($min > 0 && $max > 0) return '£' . number_format($min) . ' - £' . number_format($max);
        if ($min > 0) return '£' . number_format($min);
        return '£' . number_format($max);
    }

    public function dashboard()
    {
        $userId = $this->getUserId();
        $user = $this->userTable->find('user_id', $userId)[0] ?? null;
        $message = null;
        $error = null;

        // Handle POST actions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            try {
                switch ($action) {
                    case 'add_job':
                        $stmt = $this->pdo->prepare(
                            'INSERT INTO job_listings (title, company, location, employment_type, level, description, responsibilities, requirements, salary_range, posted_date)
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())'
                        );
                        $stmt->execute([
                            $_POST['title'] ?? '',
                            $_POST['company'] ?? '',
                            $_POST['location'] ?? '',
                            $_POST['employment_type'] ?? 'Full-time',
                            $_POST['level'] ?? 'Entry-level',
                            $_POST['description'] ?? '',
                            $_POST['responsibilities'] ?? '',
                            $_POST['requirements'] ?? '',
                            $this->formatSalaryRange($_POST['salary_min'] ?? '', $_POST['salary_max'] ?? ''),
                        ]);
                        $message = 'Job listing added successfully.';
                        break;

                    case 'delete_job':
                        $jobId = (int)($_POST['job_id'] ?? 0);
                        $stmt = $this->pdo->prepare('UPDATE job_listings SET deleted = 1 WHERE job_id = ?');
                        $stmt->execute([$jobId]);
                        $message = 'Job listing deleted.';
                        break;

                    case 'edit_job':
                        $jobId = (int)($_POST['job_id'] ?? 0);
                        $stmt = $this->pdo->prepare(
                            'UPDATE job_listings SET title = ?, company = ?, location = ?, employment_type = ?, level = ?, description = ?, responsibilities = ?, requirements = ?, salary_range = ? WHERE job_id = ? AND deleted = 0'
                        );
                        $stmt->execute([
                            $_POST['title'] ?? '',
                            $_POST['company'] ?? '',
                            $_POST['location'] ?? '',
                            $_POST['employment_type'] ?? 'Full-time',
                            $_POST['level'] ?? 'Entry-level',
                            $_POST['description'] ?? '',
                            $_POST['responsibilities'] ?? '',
                            $_POST['requirements'] ?? '',
                            $this->formatSalaryRange($_POST['salary_min'] ?? '', $_POST['salary_max'] ?? ''),
                            $jobId,
                        ]);
                        $message = 'Job listing updated successfully.';
                        break;
                }
            } catch (\Exception $e) {
                $error = 'Something went wrong: ' . $e->getMessage();
            }
        }

        // Load real jobs from DB
        $myJobs = [];
        $allJobs = [];
        $userCompany = $user['company'] ?? '';
        try {
            $stmt = $this->pdo->prepare(
                'SELECT * FROM job_listings WHERE deleted = 0 ORDER BY posted_date DESC'
            );
            $stmt->execute();
            $jobs = $stmt->fetchAll();

            foreach ($jobs as $job) {
                if ($userCompany && strcasecmp($job['company'], $userCompany) === 0) {
                    $myJobs[] = $job;
                } else {
                    $allJobs[] = $job;
                }
            }
        } catch (\Exception $e) {
            $error = $error ?? 'Unable to load job listings.';
        }

        return [
            'title' => 'Dashboard',
            'template' => 'staff-dashboard.html.php',
            'vars' => [
                'user' => $user,
                'myJobs' => $myJobs,
                'allJobs' => $allJobs,
                'message' => $message,
                'error' => $error,
            ]
        ];
    }

    public function status()
    {
        $dbConnected = false;
        $dbVersion = null;
        $totalUsers = 0;
        $totalCvs = 0;
        $totalJobs = 0;

        try {
            $stmt = $this->pdo->query('SELECT 1');
            $dbConnected = $stmt !== false;

            $dbVersion = $this->pdo->query('SELECT VERSION()')->fetchColumn();

            $totalUsers = (int) $this->pdo->query('SELECT COUNT(*) FROM users WHERE deleted = 0')->fetchColumn();
            $totalCvs = (int) $this->pdo->query('SELECT COUNT(*) FROM cvs WHERE deleted = 0')->fetchColumn();
            $totalJobs = (int) $this->pdo->query('SELECT COUNT(*) FROM job_listings WHERE deleted = 0')->fetchColumn();
        } catch (\Exception $e) {
            $dbConnected = false;
        }

        $deepseekKey = !empty(getenv('DEEPSEEK_API_KEY'));
        $geminiKey = !empty(getenv('GEMINI_API_KEY'));
        $googleClientId = !empty(getenv('GOOGLE_CLIENT_ID'));

        return [
            'title' => 'System Status',
            'template' => 'system-status.html.php',
            'vars' => [
                'dbConnected' => $dbConnected,
                'dbVersion' => $dbVersion,
                'phpVersion' => PHP_VERSION,
                'serverSoftware' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
                'totalUsers' => $totalUsers,
                'totalCvs' => $totalCvs,
                'totalJobs' => $totalJobs,
                'deepseekKey' => $deepseekKey,
                'geminiKey' => $geminiKey,
                'googleClientId' => $googleClientId,
                'memoryUsage' => round(memory_get_usage(true) / 1024 / 1024, 1),
                'uptime' => @file_get_contents('/proc/uptime') ? explode(' ', file_get_contents('/proc/uptime'))[0] : null,
            ]
        ];
    }
}