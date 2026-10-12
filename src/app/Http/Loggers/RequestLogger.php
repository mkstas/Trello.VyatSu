<?php

declare(strict_types=1);

namespace App\Http\Loggers;

use App\Library\Log;

final class RequestLogger
{
    private const BODY_MAX_LENGTH = 4096;

    private static ?self $booted = null;

    private function __construct()
    {
        ob_start();
        register_shutdown_function([$this, 'write']);
    }

    public static function boot(): self
    {
        return self::$booted ??= new self();
    }

    public function write(): void
    {
        try {
            $body = $this->flushBody();

            $startedAt = $_SERVER['REQUEST_TIME_FLOAT'] ?? $_SERVER['REQUEST_TIME'] ?? time();

            $context = [
                'method'      => $_SERVER['REQUEST_METHOD'] ?? '-',
                'uri'         => ($_SERVER['REQUEST_URI'] ?? '-') . ($_SERVER['QUERY_STRING'] ?? ''),
                'status'      => http_response_code(),
                'duration_ms' => round((microtime(true) - $startedAt) * 1000, 2),
                'ip'          => $_SERVER['REMOTE_ADDR'] ?? '-',
                'user_agent'  => $_SERVER['HTTP_USER_AGENT'] ?? '-',
                'body'        => $body,
            ];

            Log::boot()->info('http request', $context);

            echo $body;
        } catch (\Throwable $e) {
            Log::boot()->error('failed to log request', ['exception' => $e->getMessage()]);
        }
    }

    private function flushBody(): string
    {
        if (ob_get_level() === 0) {
            return '';
        }

        $body = (string) ob_get_clean();

        return mb_strimwidth($body, 0, self::BODY_MAX_LENGTH, '…');
    }
}
