<?php $routes = [
    "router" => [
        "" => [
            "controller" => "welcome",
            "function" => "welcome",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "apispecs" => [
            "controller" => "docs",
            "function" => "apispecs",
            "accept" => [
                "GET"
            ]
        ],
        "changelog" => [
            "controller" => "docs",
            "function" => "changelog",
            "accept" => [
                "GET"
            ]
        ]
    ],
    "cms" => [

    ],
    "error" => [
        "controller" => "error",
        "function" => "display",
        "accept" => [
            "GET",
            "POST"
        ]
    ],
    "notfound" => [
        "controller" => "error",
        "function" => "notfound",
        "accept" => [
            "GET",
            "POST"
        ]
    ],
    "maintenance" => [
        "controller" => "error",
        "function" => "maintenance",
        "accept" => [
            "GET",
            "POST"
        ]
    ]
]; return $routes;