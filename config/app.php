<?php return [
    'cache' => array(
        'identifier' => 'pukocache',
        'kind' => 'MEMCACHED',
        'expired' => 100,
        'host' => 'localhost',
        'port' => 11211,
    ),
    'const' => array(
        'OWNER' => 'puko'
    ),
    'logs' => array(
        'active' => false,
        'driver' => 'slack',
        'url' => '',
        'username' => 'puko',
        'emoji' => ':boom:',
        'level' => 'critical'
    )
];