<?php

namespace App\Controllers;

use Classes\DatabaseTable;

class StaffController extends Controller
{
    public function __construct(
        public \PDO $pdo,
        public DatabaseTable $userTable,
    ) {}

    public function dashboard()
    {
        $userId = $this->getUserId();
        $user = $this->userTable->find('user_id', $userId)[0] ?? null;

        return [
            'title' => 'Dashboard',
            'template' => 'staff-dashboard.html.php',
            'vars' => [
                'user' => $user,
                'tempJobs' => [
                    [
                        "title" => "Job Title 1",
                        "role" => "Job One",
                        "location" => "Northampton",
                        "skills" => [
                            "Skill 1",
                            "Skill 2",
                            "Skill 3",
                            "Skill 4"
                        ],
                        "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ],
                    [
                        "title" => "Job Title 2",
                        "role" => "Job Two",
                        "location" => "Northampton",
                        "skills" => [
                            "Skill 1",
                            "Skill 2",
                            "Skill 3",
                            "Skill 4"
                        ],
                        "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ],
                    [
                        "title" => "Job Title 3",
                        "role" => "Job Three",
                        "location" => "Northampton",
                        "skills" => [
                            "Skill 1",
                            "Skill 2",
                            "Skill 3",
                            "Skill 4"
                        ],
                        "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ],
                    [
                        "title" => "Job Title 3",
                        "role" => "Job Four",
                        "location" => "Northampton",
                        "skills" => [
                            "Skill 1",
                            "Skill 2",
                            "Skill 3",
                            "Skill 4"
                        ],
                        "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ]
                ]
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