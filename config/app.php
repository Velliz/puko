<?php

return [
    'const' => [
        'API' => ''
    ],
    'cache' => [
        'kind'    => 'MEMCACHED',
        'host'    => 'localhost',
        'port'    => 11211
    ],
    'logs' => [
        'slack' => [
            'url'      => '',
            'secure'   => '',
            'username' => 'puko-log',
            'active'   => false
        ],
        'hook' => [
            'url'      => '',
            'secure'   => '',
            'username' => 'puko-log',
            'active'   => false
        ],
    ],
];
