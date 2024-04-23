<?php

return [
    'const' => [
        'API' => null,
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
        'demo' => [
            'init_model_migration_file_name' => 'demo.sql',
            'crontab' => '0 * * * *',
        ],
        'dev' => [],
        'prod' => [],
        'maintenance' => [],
    ],
];
