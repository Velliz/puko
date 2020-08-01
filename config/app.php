<?php

return [
    'const' => [
        'API' => '',
    ],
    'cache' => [
        'kind'    => 'MEMCACHED',
        'expired' => 100,
        'host'    => 'localhost',
        'port'    => 11211,
    ],
    'logs' => [
        'slack' => [
            'url'      => '',
            'secure'   => '',
            'username' => 'puko-log',
            'active'   => false,
        ],
        'hook' => [
            'url'      => '',
            'secure'   => '',
            'username' => 'puko-log',
            'active'   => false,
        ],
    ],
];
