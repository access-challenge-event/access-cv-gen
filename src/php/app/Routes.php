<?php
namespace App;

class Routes {
    public function getPage($pageName) {
        require __DIR__ . '/../database.php';
        require_once __DIR__ . '/../includes/utils.php';

        $userTable = new \Classes\DatabaseTable($pdo, 'users', 'user_id');

        $controllers = [
            'app' => new \App\Controllers\AppController($pdo),
            'auth' => new \App\Controllers\AuthController($userTable),
        ];

        if (!$pageName) {
            $pageName = 'app/home';
        }

        $parts = explode('/', trim($pageName, '/'));
        $controllerName = $parts[0] ?? 'app';
        $method = $parts[1] ?? 'home';

        if (!isset($controllers[$controllerName]) || !method_exists($controllers[$controllerName], $method)) {
            return $controllers['app']->home();
        }

        $controller = $controllers[$controllerName];

        return $controller->$method();
    }
}
