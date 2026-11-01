<?php declare(strict_types=1);

use Framework\Http\Request;
use Framework\Http\Router;

require_once __DIR__ . '/../bootstrap.php';

$router = new Router();
require __DIR__ . '/../routes/web.php';

$router->dispatch(Request::capture())->send();
