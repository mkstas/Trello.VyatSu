<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Library\Cipher;

$output = match ($argv[1] ?? '') {
    'key:generate' => base64_encode(random_bytes(32)),
    'encrypt'      => Cipher::boot()->encrypt($argv[2] ?? ''),
    'decrypt'      => (string) Cipher::boot()->decrypt($argv[2] ?? ''),
    default        => "usage: config.php <key:generate|encrypt|decrypt> <value>",
};

echo $output, PHP_EOL;
