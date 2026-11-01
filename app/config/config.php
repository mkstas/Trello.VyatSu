<?php declare(strict_types=1);

return [
    'dev' => [
        'db' => [
            'host'     => 'enc:qrSGPkcZnvNQGQM3Z5mGSVpBryODaLSt0X6J+QLJdt+ZfD8l',
            'port'     => 'enc:4j2NJL1nq5iQRPOg4qTrZrBHvdnWEj4Ru5r5MMp2z0w=',
            'database' => 'enc:unuulrdwxDqQy9WI4kw7+rSXFvSMKiGS1rTb5U4bE9ALHg==',
            'username' => 'enc:5ESGAxyqiw4MEDMWykmYMyT4kvVT/nQvTxdfG2lzYQc=',
            'password' => 'enc:5ESGAxyqiw4MEDMWykmYMyT4kvVT/nQvTxdfG2lzYQc=',
        ],
        'session' => [
            'cookie'    => 'enc:j6Ii6jUkfdXUTL4UNu9RgdJyW5GqPM5DSjXGmHtJvXdy7QT6MQn49iFL',
            'lifetime'  => 604800,
            'idle'      => 7200,
            'secure'    => false,
            'same_site' => 'Lax'
        ],
    ],

    'test' => [
        'db' => [
            'host'     => '',
            'port'     => '',
            'database' => '',
            'username' => '',
            'password' => '',
        ],
        'session' => [
            'cookie'    => '',
            'lifetime'  => 0,
            'idle'      => 0,
            'secure'    => false,
            'same_site' => ''
        ],
    ],

    'prod' => [
        'db' => [
            'host'     => '',
            'port'     => '',
            'database' => '',
            'username' => '',
            'password' => '',
        ],
        'session' => [
            'cookie'    => '',
            'lifetime'  => 0,
            'idle'      => 0,
            'secure'    => true,
            'same_site' => ''
        ],
    ],
];
