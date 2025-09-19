<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Tentukan apakah aplikasi sedang dalam maintenance
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Daftarkan Composer Autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap aplikasi Laravel dan tangani request
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());