<?php
function autoload($className) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/app/';

    if (strncmp($className, $prefix, strlen($prefix)) === 0) {
        $relativeClass = substr($className, strlen($prefix));
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    } else {
        $file = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
    }

    if (is_file($file)) {
        require_once $file;
    }
}
spl_autoload_register('autoload');