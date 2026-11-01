<?php declare(strict_types=1);

namespace Framework\Http;

use Framework\Library\Logger;
use Throwable;

final class RequestLogger
{
    private static ?self $booted = null;

    private ?Throwable $exception = null;

    public static function boot(): self
    {
        return self::$booted ??= new self();
    }

    public function capture(Throwable $exception): void
    {
        $this->exception = $exception;
    }

    public function write(): void
    {
        $startedAt = (float) ($_SERVER['REQUEST_TIME_FLOAT'] ?? microtime(true));

        $entry = [
            'method'      => $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN',
            'uri'         => $_SERVER['REQUEST_URI'] ?? '',
            'status'      => http_response_code() ?: 0,
            'duration_ms' => (int) round((microtime(true) - $startedAt) * 1000),
        ];

        if ($this->exception !== null) {
            $entry['exception'] = $this->exception::class;
            $entry['message']   = $this->exception->getMessage();
        }

        Logger::boot('request')->info('http request', $entry);
    }
}
