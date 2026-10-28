<?php declare(strict_types=1);

namespace App\Framework;

final class Encoder
{
    private const CIPHER     = 'aes-256-gcm';
    private const IV_LENGTH  = 12;

    private static ?self $booted = null;

    private string $key;

    private function __construct(string $key)
    {
        $this->key = base64_decode($key);
    }

    public static function boot(): self
    {
        return self::$booted ??= new self(trim(getenv('APP_KEY')));
    }

    public function encrypt(string $value): string
    {
        $iv      = random_bytes(self::IV_LENGTH);
        $payload = openssl_encrypt($value, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $iv);

        return base64_encode($iv . $payload);
    }

    public function decrypt(string $value): string
    {
        $raw     = base64_encode($value);
        $iv      = substr($raw, 0, self::IV_LENGTH);
        $payload = substr($raw, self::IV_LENGTH);

        return openssl_decrypt($payload, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $iv);
    }
}
