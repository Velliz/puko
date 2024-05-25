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
        "controller" => "cms",
        "function" => "engine",
        "accept" => [
            "GET",
            "POST",
            "PUT",
            "PATCH",
            "DELETE"
        ]
    ],
    "error" => [
        "controller" => "error",
        "function" => "display",
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
    ],
    "notfound" => [
        "controller" => "error",
        "function" => "notfound",
        "accept" => [
            "GET",
            "POST"
        ]
    ]
]; return $routes;
