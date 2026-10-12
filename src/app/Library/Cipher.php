<?php

declare(strict_types=1);

namespace App\Library;

final class Cipher
{
    private const CIPHER = 'aes-256-gcm';
    private const IV_LENGTH = 12;
    private const TAG_LENGTH = 16;

    private static ?self $booted = null;

    private string $key;

    private function __construct(string $key)
    {
        $this->key = base64_decode($key);
    }

    public static function boot(): self
    {
        return self::$booted ??= new self(trim((string) getenv('APP_KEY')));
    }

    public function encrypt(string $value): string
    {
        $iv = random_bytes(self::IV_LENGTH);

        $tag = '';

        $payload = openssl_encrypt($value, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $iv, $tag);

        return base64_encode($iv . $tag . $payload);
    }

    public function decrypt(string $value): ?string
    {
        $raw = base64_decode($value);

        $iv = substr($raw, 0, self::IV_LENGTH);
        $tag = substr($raw, self::IV_LENGTH, self::TAG_LENGTH);
        $payload = substr($raw, self::IV_LENGTH + self::TAG_LENGTH);

        $plain = openssl_decrypt($payload, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $iv, $tag);

        return $plain === false ? null : $plain;
    }
}
