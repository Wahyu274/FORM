<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
} elseif (file_exists($maintenance = __DIR__.'/../../lsc_app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Auto Loader...
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
} elseif (file_exists(__DIR__.'/../../lsc_app/vendor/autoload.php')) {
    require __DIR__.'/../../lsc_app/vendor/autoload.php';
}

// Bootstrap Laravel and handle the request...
if (file_exists(__DIR__.'/../bootstrap/app.php')) {
    $app = require_once __DIR__.'/../bootstrap/app.php';
} elseif (file_exists(__DIR__.'/../../lsc_app/bootstrap/app.php')) {
    $app = require_once __DIR__.'/../../lsc_app/bootstrap/app.php';
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
