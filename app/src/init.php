<?php declare(strict_types=1);

use App\Http\RequestLogger;

require_once __DIR__ . '/vendor/autoload.php';

define('ROOT_DIR', __DIR__);

set_error_handler(function(int $severety, string $message, string $file, int $line) {
    if (!error_reporting() & $severety) {
        return false;
    }

    throw new ErrorException($message, 0, $severety, $file, $line);
});

set_exception_handler(function (Throwable $exception) {
    RequestLogger::boot()->write($exception);

    if (PHP_SAPI === 'cli') {
        exit(1);
    }

    http_response_code(500);
});
