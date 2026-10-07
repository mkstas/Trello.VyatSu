<?php

declare(strict_types=1);

namespace App\Libraries;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

final class Logger
{
    private static ?Logger $logger = null;

    public static function create(): Logger
    {
        if (self::$logger !== null) {
            return self::$logger;
        }

        // Создаем канал с именем 'app'
        $logger = new Logger('app');

        // 1. Форматтер для красивого вывода сообщений
        $output = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
        $formatter = new LineFormatter($output, 'Y-m-d H:i:s', true, true);

        // 2. Ротация файлов: создает новый файл каждый день, хранит последние 14 дней
        $logPath = __DIR__ . '/../logs/app.log';
        $fileHandler = new RotatingFileHandler($logPath, 14, Logger::DEBUG);
        $fileHandler->setFormatter($formatter);

        // 3. Вывод ошибок в стандартный поток ошибок (полезно для Docker/консоли)
        $stderrHandler = new StreamHandler('php://stderr', Logger::ERROR);

        // Регистрируем обработчики
        $logger->pushHandler($fileHandler);
        $logger->pushHandler($stderrHandler);

        self::$logger = $logger;

        return self::$logger;
    }
}
