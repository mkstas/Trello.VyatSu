<?php declare(strict_types=1);

namespace Framework\Library;

use Illuminate\Filesystem\Filesystem;

final class Config
{
    private static ?self $booted = null;

    private array $items = [];

    private function __construct()
    {
        $files  = new Filesystem();
        $config = $files->getRequire(ROOT_DIR . '/config/config.php');
        $env    = trim(getenv('APP_ENV') ?: 'dev');

        $this->items = $config[$env];
    }

    public static function boot(): self
    {
        return self::$booted ??= new self();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $value = $this->items;

        foreach (explode('.', $key) as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)){
                return $default;
            }

            $value = $value[$segment];
        }

        if (is_string($value) && str_starts_with($value, Encoder::PREFIX)) {
            return Encoder::boot()->decrypt($value) ?? $default;
        }

        return $value;
    }
}
