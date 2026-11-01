<?php declare(strict_types=1);

use Framework\Controllers\HomeController;
use Framework\Http\Router;

/** @var Router $router */

$router->get('/', [HomeController::class, 'index']);
