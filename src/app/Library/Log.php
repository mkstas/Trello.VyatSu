<?php

declare(strict_types=1);

namespace App\Library;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\WhatFailureGroupHandler;
use Monolog\Level;
use Monolog\Logger as MonologLogger;

final class Log extends MonologLogger
{
    private static ?self $booted = null;

    private function __construct()
    {
        parent::__construct('app');

        $formatter = new LineFormatter(
            "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
            'Y-m-d H:i:s',
        );
        $formatter->includeStacktraces(true);

        $logPath = dirname(__DIR__, 2) . '/logs/app.log';

        $file = new RotatingFileHandler($logPath, 14, Level::Debug);
        $file->setFormatter($formatter);

        $stderr = new StreamHandler('php://stderr', Level::Error);
        $stderr->setFormatter($formatter);

        $this->pushHandler(new WhatFailureGroupHandler([$file, $stderr]));
    }

    public static function boot(): self
    {
        return self::$booted ??= new self();
    }
}
