<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');

$checks = [
    'php' => 'ok',
];
$httpStatus = 200;

http_response_code($httpStatus);

echo json_encode([
    'status' => $httpStatus,
    'checks' => $checks,
], JSON_UNESCAPED_UNICODE);
