<?php

declare(strict_types=1);

return [
    'dev' => [
        'app' => [
            'name' => 'trello',
            'debug' => true,
        ],

        'db' => [
            'host'     => '5XJF1gjllDHlrM6o5e2nkl63NC5jmywmHyyIup50d027xaDn',
            'port'     => 'ostkrdLA+yPhl6G8Z5RrL3oB+mN8LgpZZb4TMN3DAqg=',
            'database' => 'ysnlROin0Zpjm8pCDdagSX4z399E2qccWeTxGetYS6xu9g==',
            'username' => '+eFuNARnlYstoO9jrDeCtRwM7EmCNJnWJEY52omNinU=',
            'password' => '5I0dcsJOGmbNz31+2w038jriwh6jUqFwS7oz1QtZSxo=',
        ],
    ],

    'test' => [
        'app' => [
            'name' => 'trello',
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
            'name' => 'trello',
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
