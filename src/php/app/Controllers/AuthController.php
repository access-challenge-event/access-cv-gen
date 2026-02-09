<?php

namespace App\Controllers;

use Classes\DatabaseTable;

use function login;
use function redirect;
use function is_logged_in;

class AuthController
{
    public function __construct(
        public DatabaseTable $userTable,
    ) {}

    public function login() {
        if (isset($_SESSION['loggedIn'])) {
            if (($_SESSION['loggedIn']['role'] ?? null) === 'staff') {
                redirect('/staff/dashboard');
            }
            redirect('/');
        }

        $error = null;

        if (isset($_POST['submit'])) {
            $credentials = $_POST['login'];
            $users = $this->userTable->find('email', $credentials['email']);

            if (count($users) > 0) {
                $user = $users[0];

                if (password_verify($credentials['password'], $user['password'])) {
                    // login user
                    login($user);

                    if (($user['role'] ?? null) === 'staff') {
                        redirect('/staff/dashboard');
                    }

                    redirect('/');
                    unset($_POST);
                } else {
                    $error = 'Invalid email or password.';
                }
            } else {
                $error = 'Invalid email or password.';
            }
        }

        return [
            'title' => 'Login',
            'template' => 'login.html.php',
            'vars' => [
                'error' => $error
            ]
        ];
    }

    public function register() {
        $error = null;

        if (isset($_POST['submit'])) {
            $username = $_POST['register']['username'];
            $email = $_POST['register']['email'];
            $password = $_POST['register']['password'];

            // Check for existing username
            $existingUsername = $this->userTable->find('username', $username);
            if (count($existingUsername) > 0) {
                $error = 'Username already exists. Please choose a different username.';
            }

            // Check for existing email
            $existingEmail = $this->userTable->find('email', $email);
            if (count($existingEmail) > 0) {
                $error = 'Email already registered. Please use a different email or sign in.';
            }

            // If no errors, create the user
            if ($error === null) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $record = [
                    'user_id' => '',
                    'username' => $username,
                    'email' => $email,
                    'password' => $hashedPassword,
                ];

                // save user then fetch
                $this->userTable->save($record);

                $users = $this->userTable->find('username', $username);

                if (count($users) > 0) {
                    $user = $users[0];
                    login($user);
                }

                unset($_POST);
                redirect('/');
            }
        }

        return [
            'title' => 'Register',
            'template' => 'register.html.php',
            'vars' => [
                'error' => $error
            ]
        ];
    }

    public function logout() {
        if (isset($_SESSION['loggedIn'])) {
            unset($_SESSION['loggedIn']);
            
            redirect('/auth/login');
        }
    }
}