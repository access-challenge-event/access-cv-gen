<?php
namespace App;

use App\Middleware\AuthMiddleware;
use App\Middleware\StaffMiddleware;
use App\Middleware\NotStaffMiddleware;
use App\Exceptions\ForbiddenException;

class Routes {

    /**
     * Map of "controller/method" => middleware instances.
     * Add entries here to protect routes.
     */
    private function getMiddleware(): array {
        return [
            'staff/dashboard' => [new StaffMiddleware()],
            'app/create' => [new AuthMiddleware(), new NotStaffMiddleware()],
            'app/viewCv' => [new AuthMiddleware(), new NotStaffMiddleware()],
            'app/myCvs' => [new AuthMiddleware(), new NotStaffMiddleware()],
            'app/profile' => [new AuthMiddleware()],
        ];
    }

    public function getPage($pageName) {
        require __DIR__ . '/../database.php';
        require __DIR__ . '/../classes/DatabaseTable.php';
        require_once __DIR__ . '/../includes/utils.php';

        $userTable = new \Classes\DatabaseTable($pdo, 'users', 'user_id');

        $controllers = [
            'app' => new \App\Controllers\AppController($pdo),
            'auth' => new \App\Controllers\AuthController($userTable),
            'staff' => new \App\Controllers\StaffController($pdo, $userTable),
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

        $routeKey = $controllerName . '/' . $method;
        $middlewareMap = $this->getMiddleware();

        if (isset($middlewareMap[$routeKey])) {
            foreach ($middlewareMap[$routeKey] as $middleware) {
                try {
                    $middleware->handle();
                } catch (ForbiddenException $e) {
                    http_response_code(403);
                    return [
                        'title' => '403 Forbidden',
                        'template' => '403.html.php',
                        'vars' => []
                    ];
                }
            }
        }

        $controller = $controllers[$controllerName];

        return $controller->$method();
    }
}
