<?php declare(strict_types=1);

namespace App\Http;

use App\Framework\Logger;

final class RequestLogger
{
    private static ?self $booted = null;

    public static function boot(): self
    {
        return self::$booted ??= new self();
    }

    public function write($exception): void
    {
        $entry = [
                'uri'    => $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'],
                'method' => $_SERVER['REQUEST_METHOD'],
            ];

        Logger::boot('requests')->info('http request', $entry);
    }
}
