<?php

return [
    'const' => [
        'API' => '',
    ],
    'cache' => [
        'kind'    => 'MEMCACHED',
        'host'    => 'localhost',
        'port'    => 11211,
        'active'    => false,
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
