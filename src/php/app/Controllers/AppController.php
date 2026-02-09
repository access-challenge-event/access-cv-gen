<?php

namespace App\Controllers;

use function login_check;

class AppController
{
    public function __construct(
        private \PDO $pdo
    ) {}

    private function getUserId(): int
    {
        return $_SESSION['loggedIn']['id'] ?? 0;
    }

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

    public function create()
    {
        login_check();

        $userId = $this->getUserId();
        $message = null;
        $error = null;

        // Handle form submissions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            try {
                switch ($action) {
                    case 'add_education':
                        $this->addEducation($userId, $_POST);
                        $message = 'Education added successfully.';
                        break;
                    case 'delete_education':
                        $this->deleteEducation($userId, (int)$_POST['education_id']);
                        $message = 'Education deleted.';
                        break;
                    case 'add_experience':
                        $this->addExperience($userId, $_POST);
                        $message = 'Experience added successfully.';
                        break;
                    case 'delete_experience':
                        $this->deleteExperience($userId, (int)$_POST['experience_id']);
                        $message = 'Experience deleted.';
                        break;
                    case 'add_award':
                        $this->addAward($userId, $_POST);
                        $message = 'Award added successfully.';
                        break;
                    case 'delete_award':
                        $this->deleteAward($userId, (int)$_POST['award_id']);
                        $message = 'Award deleted.';
                        break;
                    case 'update_profile':
                        $this->updateProfile($userId, $_POST);
                        $message = 'Profile updated successfully.';
                        break;
                }
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }

        // Load user data
        $user = $this->getUser($userId);
        $education = $this->getEducation($userId);
        $experience = $this->getExperience($userId);
        $awards = $this->getAwards($userId);
        $jobListings = $this->getJobListings();

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

    private function getUser(int $userId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE user_id = ? AND deleted = 0');
        $stmt->execute([$userId]);
        return $stmt->fetch() ?: null;
    }

    private function updateProfile(int $userId, array $data): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE users SET firstname = ?, lastname = ?, about = ? WHERE user_id = ?'
        );
        $stmt->execute([
            $data['firstname'] ?? '',
            $data['lastname'] ?? '',
            $data['about'] ?? '',
            $userId
        ]);
    }

    private function getEducation(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM education WHERE user_id = ? AND deleted = 0 ORDER BY graduation_date DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    private function addEducation(int $userId, array $data): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO education (user_id, title, school, length, graduation_date) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $userId,
            $data['title'] ?? '',
            $data['school'] ?? '',
            (int)($data['length'] ?? 0),
            $data['graduation_date'] ?? date('Y-m-d')
        ]);
    }

    private function deleteEducation(int $userId, int $educationId): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE education SET deleted = 1 WHERE education_id = ? AND user_id = ?'
        );
        $stmt->execute([$educationId, $userId]);
    }

    private function getExperience(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM experience WHERE user_id = ? AND deleted = 0 ORDER BY date_created DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    private function addExperience(int $userId, array $data): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO experience (user_id, job_title, location, duration, content) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $userId,
            $data['job_title'] ?? '',
            $data['location'] ?? '',
            $data['duration'] ?? '',
            $data['content'] ?? ''
        ]);
    }

    private function deleteExperience(int $userId, int $experienceId): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE experience SET deleted = 1 WHERE experience_id = ? AND user_id = ?'
        );
        $stmt->execute([$experienceId, $userId]);
    }

    private function getAwards(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM awards WHERE user_id = ? AND deleted = 0 ORDER BY date_created DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    private function addAward(int $userId, array $data): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO awards (user_id, title, description) VALUES (?, ?, ?)'
        );
        $stmt->execute([
            $userId,
            $data['title'] ?? '',
            $data['description'] ?? ''
        ]);
    }

    private function deleteAward(int $userId, int $awardId): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE awards SET deleted = 1 WHERE award_id = ? AND user_id = ?'
        );
        $stmt->execute([$awardId, $userId]);
    }

    private function getJobListings(): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT job_id, title, company FROM job_listings WHERE deleted = 0 ORDER BY posted_date DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
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
