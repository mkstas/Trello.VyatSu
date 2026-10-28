<?php declare(strict_types=1);

namespace App\Framework;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\WhatFailureGroupHandler;
use Monolog\Level;
use Monolog\Logger as MonologLogger;

final class Logger extends MonologLogger
{
    private static array $instances = [];

    private function __construct(string $name)
    {
        parent::__construct($name);

        $formatter = new LineFormatter(
            "[%datetime%] %level_name%: %message% %context% %extra%\n",
            'Y-m-d H:i:s',
        );
        $formatter->includeStacktraces(true);

        $logDir = ROOT_DIR . '/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0777, true);
        }

        $logPath = $logDir . sprintf('/%s.log', $name);
        $file    = new RotatingFileHandler($logPath, 16, Level::Debug);
        $stderr  = new StreamHandler('php://stderr', Level::Error);

        $file->setFormatter($formatter);
        $stderr->setFormatter($formatter);

        $this->pushHandler(new WhatFailureGroupHandler([$file, $stderr]));
    }

    public static function boot(string $name = 'app'): self
    {
        if (!isset(self::$instances[$name])) {
            self::$instances[$name] = new self($name);
        }

        return self::$instances[$name];
    }
}
