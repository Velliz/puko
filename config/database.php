<?php

$db['primary'] = [
    'dbType' => 'mysql',
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'dbName' => '',
    'port' => '3306',
    'driver' => '',
    'ignoreTableWithPrefix' => '_',
    'hideColumns' => [
        'created', 'modified', 'cuid', 'muid', 'dflag', 'password'
    ]
];
$db['logs'] = [
    'dbType' => 'mysql',
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'dbName' => '',
    'port' => '3306',
    'driver' => '',
    'ignoreTableWithPrefix' => '_',
    'hideColumns' => [
        'created', 'modified', 'cuid', 'muid', 'dflag', 'password'
    ]
];
$db['backup'] = [
    'dbType' => 'mysql',
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'dbName' => '',
    'port' => '3306',
    'driver' => '',
    'ignoreTableWithPrefix' => '_',
    'hideColumns' => [
        'created', 'modified', 'cuid', 'muid', 'dflag', 'password'
    ]
];

return $db;
