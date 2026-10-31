<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Framework\Library\Encoder;

$output = match ($argv[1] ?? '') {
    'key:generate' => base64_encode(random_bytes(32)),
    'encrypt'      => Encoder::boot()->encrypt($argv[2] ?? ''),
    'decrypt'      => Encoder::boot()->decrypt($argv[2] ?? ''),
    default        => "usage: config.php <key:generate|encrypt|decrypt> <value>",
};

echo $output, PHP_EOL;
