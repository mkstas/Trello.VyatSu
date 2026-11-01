<?php declare(strict_types=1);

namespace Framework\Http;

final class Request
{
    private function __construct(
        private string $method,
        private string $path,
    ) {
    }

    public static function capture(): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        if ($method === 'POST' && isset($_POST['_method'])) {
            $candidate = strtoupper((string) $_POST['_method']);

            if (in_array($candidate, ['PUT', 'PATCH', 'DELETE'], true)) {
                $method = $candidate;
            }
        }

        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $path = '/' . trim($path, '/');

        return new self($method, $path);
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }
}
