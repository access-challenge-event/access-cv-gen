<?php
/**
 * CV Generator - Main Application Entry Point
 * Routes requests to appropriate page content
 */

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/includes/config.php';

$entryPoint = new \App\EntryPoint(new \App\Routes());
$entryPoint->run();
