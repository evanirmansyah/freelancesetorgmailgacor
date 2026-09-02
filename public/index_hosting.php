<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| INDEX.PHP UNTUK HOSTING - jualgmail.my.id
|--------------------------------------------------------------------------
| File ini menggantikan index.php di public_html/ setelah deploy.
| Path: public_html/index.php
| Laravel app ada di: ~/setoran-app/ (satu level di atas public_html)
*/

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../setoran-app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../setoran-app/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../setoran-app/bootstrap/app.php';

$app->handleRequest(Request::capture());
