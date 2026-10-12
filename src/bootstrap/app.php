<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

if (PHP_SAPI === 'cli') {
    return;
}

App\Http\Loggers\RequestLogger::boot();
