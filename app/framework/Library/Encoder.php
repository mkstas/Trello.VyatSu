<?php declare(strict_types=1);

namespace Framework\Library;

use RuntimeException;

final class Encoder
{
    public const PREFIX = 'enc:';

    private const CIPHER     = 'aes-256-gcm';
    private const IV_LENGTH  = 12;
    private const TAG_LENGTH = 16;

    private static ?self $booted = null;

    private string $key;

    private function __construct(string $key)
    {
        $this->key = base64_decode($key, true);
    }

    public static function boot(): self
    {
        return self::$booted ??= new self(trim((string) getenv('APP_KEY')));
    }

    public function encrypt(string $value): string
    {
        $iv      = random_bytes(self::IV_LENGTH);
        $tag     = '';
        $payload = openssl_encrypt($value, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $iv, $tag);

        if ($payload === false) {
            throw new RuntimeException('Unable to encrypt value');
        }

        return self::PREFIX . base64_encode($iv . $tag . $payload);
    }

    public function decrypt(string $value): ?string
    {
        if (str_starts_with($value, self::PREFIX)) {
            $value = substr($value, strlen(self::PREFIX));
        }

        $raw = base64_decode($value, true);

        if ($raw === false || strlen($raw) <= self::IV_LENGTH + self::TAG_LENGTH) {
            return null;
        }

        $iv      = substr($raw, 0, self::IV_LENGTH);
        $tag     = substr($raw, self::IV_LENGTH, self::TAG_LENGTH);
        $payload = substr($raw, self::IV_LENGTH + self::TAG_LENGTH);

        $decrypted = @openssl_decrypt($payload, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $iv, $tag);

        return $decrypted === false ? null : $decrypted;
    }
}
