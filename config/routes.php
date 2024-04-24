<?php

$routes = [
    'router' => [
        '' => [
            'controller' => 'welcome',
            'function'   => 'welcome',
            'accept'     => [
                'GET', 'POST',
            ],
        ],
    ],
    'error' => [
        'controller' => 'error',
        'function'   => 'display',
        'accept'     => [
            'GET',
            'POST',
        ],
    ],
    'not_found' => [
        'controller' => 'error',
        'function'   => 'not_found',
        'accept'     => [
            'GET',
            'POST',
        ],
    ],
    'maintenance' => [
        'controller' => 'error',
        'function'   => 'maintenance',
        'accept'     => [
            'GET',
            'POST',
        ],
    ],
];

return $routes;
