<?php
namespace App;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class EntryPoint {
    public function __construct(
        public $routes,
    ) {}

    public function run() {
        $pageName = explode('?', ltrim($_SERVER['REQUEST_URI'], '/'))[0];
        $layout = __DIR__ . '/../templates/app-layout.html.php';
        $templateDir = __DIR__ . '/../templates/pages/';

        $page = $this->routes->getPage($pageName);

        $title = $page['title'];
        $content = $this->load_template($templateDir . $page['template'], $page['vars']);

        // Expose config globals to the layout scope.
        $app_env = $GLOBALS['app_env'] ?? 'development';
        $page = $GLOBALS['page'] ?? 'home';

        require  $layout;
    }

    function load_template($fileName, $tempVars) {
        extract($tempVars);
        ob_start();
        require $fileName;
        $contents = ob_get_clean();
    
        return $contents;
    }
}