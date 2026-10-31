<?php declare(strict_types=1);

use Framework\Http\RequestLogger;

require_once __DIR__ . '/vendor/autoload.php';

define('ROOT_DIR', __DIR__);

set_error_handler(function(int $severety, string $message, string $file, int $line) {
    if (!(error_reporting() & $severety)) {
        return false;
    }

    throw new ErrorException($message, 0, $severety, $file, $line);
});

set_exception_handler(function (Throwable $exception) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, sprintf("%s: %s\n", $exception::class, $exception->getMessage()));
        exit(1);
    }

    RequestLogger::boot()->capture($exception);

    http_response_code(500);
});

if (PHP_SAPI !== 'cli') {
    register_shutdown_function(static function (): void {
        RequestLogger::boot()->write();
    });
}
