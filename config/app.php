<?php

return [
    'const' => [
        'CMS_MODE' => false,
    ],
    'cache' => [
        'kind' => 'MEMCACHED',
        'host' => 'localhost',
        'port' => 11211,
        'active' => false,
    ],
    'logs' => [
        'slack' => [
            'url' => '',
            'secure' => '',
            'username' => 'slack-pukoframework-log',
            'active' => false,
        ],
        'hook' => [
            'url' => '',
            'secure' => '',
            'username' => 'hook-pukoframework-log',
            'active' => false,
        ],
    ],
    'environment' => [
        'demo' => [],
        'dev' => [],
        'prod' => [],
        'maintenance' => [],
    ],
];
