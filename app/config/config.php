<?php declare(strict_types=1);

return [
    'dev' => [
        'app' => [
            'debug' => true,
        ],
        'db' => [
            'host'     => 'enc:qrSGPkcZnvNQGQM3Z5mGSVpBryODaLSt0X6J+QLJdt+ZfD8l',
            'port'     => 'enc:4j2NJL1nq5iQRPOg4qTrZrBHvdnWEj4Ru5r5MMp2z0w=',
            'database' => 'enc:unuulrdwxDqQy9WI4kw7+rSXFvSMKiGS1rTb5U4bE9ALHg==',
            'username' => 'enc:5ESGAxyqiw4MEDMWykmYMyT4kvVT/nQvTxdfG2lzYQc=',
            'password' => 'enc:5ESGAxyqiw4MEDMWykmYMyT4kvVT/nQvTxdfG2lzYQc=',
        ],
    ],

    'test' => [
        'app' => [
            'debug' => true,
        ],
        'db' => [
            'host'     => '',
            'port'     => '',
            'database' => '',
            'username' => '',
            'password' => '',
        ],
    ],

    'prod' => [
        'app' => [
            'debug' => false,
        ],
        'db' => [
            'host'     => '',
            'port'     => '',
            'database' => '',
            'username' => '',
            'password' => '',
        ],
    ],
];
