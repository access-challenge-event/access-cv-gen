<?php

namespace App\Controllers;

use function login_check;

class AppController
{
    public function __construct(
        private \PDO $pdo
    ) {}

    public function home() {
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

    private function getUserId(): int
    {
        return $_SESSION['loggedIn']['id'] ?? 0;
    }

    public function create()
    {
        login_check();

        $userId = $this->getUserId();
        $message = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            try {
                switch ($action) {
                    case 'add_education':
                        $stmt = $this->pdo->prepare(
                            'INSERT INTO education (user_id, title, school, length, graduation_date) VALUES (?, ?, ?, ?, ?)'
                        );
                        $stmt->execute([
                            $userId,
                            $_POST['title'] ?? '',
                            $_POST['school'] ?? '',
                            (int)($_POST['length'] ?? 0),
                            $_POST['graduation_date'] ?? date('Y-m-d')
                        ]);
                        $message = 'Education added successfully.';
                        break;

                    case 'delete_education':
                        $stmt = $this->pdo->prepare(
                            'UPDATE education SET deleted = 1 WHERE education_id = ? AND user_id = ?'
                        );
                        $stmt->execute([(int)$_POST['education_id'], $userId]);
                        $message = 'Education deleted.';
                        break;

                    case 'add_experience':
                        $stmt = $this->pdo->prepare(
                            'INSERT INTO experience (user_id, job_title, location, duration, content) VALUES (?, ?, ?, ?, ?)'
                        );
                        $stmt->execute([
                            $userId,
                            $_POST['job_title'] ?? '',
                            $_POST['location'] ?? '',
                            $_POST['duration'] ?? '',
                            $_POST['content'] ?? ''
                        ]);
                        $message = 'Experience added successfully.';
                        break;

                    case 'delete_experience':
                        $stmt = $this->pdo->prepare(
                            'UPDATE experience SET deleted = 1 WHERE experience_id = ? AND user_id = ?'
                        );
                        $stmt->execute([(int)$_POST['experience_id'], $userId]);
                        $message = 'Experience deleted.';
                        break;

                    case 'add_award':
                        $stmt = $this->pdo->prepare(
                            'INSERT INTO awards (user_id, title, description) VALUES (?, ?, ?)'
                        );
                        $stmt->execute([
                            $userId,
                            $_POST['title'] ?? '',
                            $_POST['description'] ?? ''
                        ]);
                        $message = 'Award added successfully.';
                        break;

                    case 'delete_award':
                        $stmt = $this->pdo->prepare(
                            'UPDATE awards SET deleted = 1 WHERE award_id = ? AND user_id = ?'
                        );
                        $stmt->execute([(int)$_POST['award_id'], $userId]);
                        $message = 'Award deleted.';
                        break;

                    case 'update_profile':
                        $stmt = $this->pdo->prepare(
                            'UPDATE users SET firstname = ?, lastname = ?, about = ? WHERE user_id = ?'
                        );
                        $stmt->execute([
                            $_POST['firstname'] ?? '',
                            $_POST['lastname'] ?? '',
                            $_POST['about'] ?? '',
                            $userId
                        ]);
                        $message = 'Profile updated successfully.';
                        break;
                }
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }

        // Load user
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE user_id = ? AND deleted = 0');
        $stmt->execute([$userId]);
        $user = $stmt->fetch() ?: null;

        // Load education
        $stmt = $this->pdo->prepare('SELECT * FROM education WHERE user_id = ? AND deleted = 0 ORDER BY graduation_date DESC');
        $stmt->execute([$userId]);
        $education = $stmt->fetchAll();

        // Load experience
        $stmt = $this->pdo->prepare('SELECT * FROM experience WHERE user_id = ? AND deleted = 0 ORDER BY date_created DESC');
        $stmt->execute([$userId]);
        $experience = $stmt->fetchAll();

        // Load awards
        $stmt = $this->pdo->prepare('SELECT * FROM awards WHERE user_id = ? AND deleted = 0 ORDER BY date_created DESC');
        $stmt->execute([$userId]);
        $awards = $stmt->fetchAll();

        // Load job listings
        $stmt = $this->pdo->prepare('SELECT job_id, title, company FROM job_listings WHERE deleted = 0 ORDER BY posted_date DESC');
        $stmt->execute();
        $jobListings = $stmt->fetchAll();

        return [
            'title' => 'Create CV',
            'template' => 'create-cv.html.php',
            'vars' => [
                'user' => $user,
                'education' => $education,
                'experience' => $experience,
                'awards' => $awards,
                'jobListings' => $jobListings,
                'message' => $message,
                'error' => $error,
            ]
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

    public function profile()
    {
        login_check();

        $userId = $this->getUserId();
        $message = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $action = $_POST['action'] ?? '';

                switch ($action) {
                    case 'update_profile':
                        $stmt = $this->pdo->prepare(
                            'UPDATE users SET firstname = ?, lastname = ?, age = ?, about = ? WHERE user_id = ?'
                        );
                        $stmt->execute([
                            $_POST['firstname'] ?? '',
                            $_POST['lastname'] ?? '',
                            $_POST['age'] ?: null,
                            $_POST['about'] ?? '',
                            $userId
                        ]);

                        // Update session username if changed
                        if (!empty($_POST['username'])) {
                            $existing = $this->pdo->prepare('SELECT user_id FROM users WHERE username = ? AND user_id != ?');
                            $existing->execute([$_POST['username'], $userId]);
                            if ($existing->rowCount() === 0) {
                                $stmtU = $this->pdo->prepare('UPDATE users SET username = ? WHERE user_id = ?');
                                $stmtU->execute([$_POST['username'], $userId]);
                                $_SESSION['loggedIn']['username'] = $_POST['username'];
                            } else {
                                $error = 'That username is already taken.';
                            }
                        }

                        if (!$error) {
                            $message = 'Profile updated successfully.';
                        }
                        break;

                    case 'change_password':
                        $current = $_POST['current_password'] ?? '';
                        $new = $_POST['new_password'] ?? '';
                        $confirm = $_POST['confirm_password'] ?? '';

                        if ($new !== $confirm) {
                            $error = 'New passwords do not match.';
                            break;
                        }
                        if (strlen($new) < 6) {
                            $error = 'New password must be at least 6 characters.';
                            break;
                        }

                        $stmt = $this->pdo->prepare('SELECT password FROM users WHERE user_id = ?');
                        $stmt->execute([$userId]);
                        $row = $stmt->fetch();

                        if (!$row || !password_verify($current, $row['password'])) {
                            $error = 'Current password is incorrect.';
                            break;
                        }

                        $hashed = password_hash($new, PASSWORD_DEFAULT);
                        $stmt = $this->pdo->prepare('UPDATE users SET password = ? WHERE user_id = ?');
                        $stmt->execute([$hashed, $userId]);
                        $message = 'Password changed successfully.';
                        break;
                }
            } catch (\Exception $e) {
                $error = 'Something went wrong. Please try again.';
            }
        }

        // Load user data
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE user_id = ? AND deleted = 0');
        $stmt->execute([$userId]);
        $user = $stmt->fetch() ?: null;

        return [
            'title' => 'My Profile',
            'template' => 'profile.html.php',
            'vars' => [
                'user' => $user,
                'message' => $message,
                'error' => $error,
            ]
        ];
    }
}