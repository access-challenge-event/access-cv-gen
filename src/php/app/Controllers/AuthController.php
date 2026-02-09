<?php

namespace App\Controllers;

use Classes\DatabaseTable;

class AuthController
{
    public function __construct(
        //public DatabaseTable $userTable,
    ) {}

    public function login() {
        if (isset($_SESSION['loggedIn'])) {
            redirect('/');
        }

        if (isset($_POST['submit'])) {
            $credentials = $_POST['login'];
            $users = $this->userTable->find('username', $credentials['username']);

            if (count($users) > 0) {
                $user = $users[0];

                if (password_verify($credentials['password'], $user['password'])) {
                    // login user
                    login($user);
                    redirect('/');
                    unset($_POST);
                }
            }
        }

        return [
            'title' => 'Login',
            'template' => 'login.html.php',
            'vars' => []
        ];
    }

    public function register() {
        if (isset($_POST['submit'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $username = $_POST['username'];
            $email = $_POST['email'];

            $record = [
                'id' => '',
                'username' => $username,
                'password' => $password,
                'email' => $email,
            ];

            // save user then fetch
            $this->userTable->save($record);

            $users = $this->userTable->find('username', $username);

            if (count($users) > 0) {
                $user = $users[0];

                // log in the user automatically
                login($user);
            }

            unset($_POST);

            redirect('/auth/login');
        }

        return [
            'title' => 'Register',
            'template' => 'register.html.php',
            'vars' => []
        ];
    }

    public function logout() {
        if (isset($_SESSION['loggedIn'])) {
            unset($_SESSION['loggedIn']);
            
            redirect('/auth/login');
        }
    }
}