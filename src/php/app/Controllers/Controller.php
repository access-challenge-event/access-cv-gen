<?php

namespace App\Controllers;

abstract class Controller {
    public function getUserId() {
        $session = $_SESSION['loggedIn'] ?? null;
        return $session['id'] ?? 0;
    }
}