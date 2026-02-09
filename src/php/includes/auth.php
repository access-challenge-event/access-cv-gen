<?php
/**
 * Auth/bootstrap helpers (session, vendor autoload, shared utils)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$vendorAutoload = __DIR__ . '/../vendor/autoload.php';
if (is_file($vendorAutoload)) {
    require_once $vendorAutoload;
}

require_once __DIR__ . '/utils.php';