<?php $routes = [
    "page" => [
        "" => [
            "controller" => "error",
            "function" => "display",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
    ],
    "error" => [
        "controller" => "error",
        "function" => "display",
        "accept" => [
            "GET",
            "POST"
        ]
    ],
    "not_found" => [
        "controller" => "error",
        "function" => "notfound",
        "accept" => [
            "GET",
            "POST"
        ]
    ]
]; return $routes;