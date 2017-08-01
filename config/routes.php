<?php $routes = [
    "page" => [
        "" => [
            "controller" => "main",
            "function" => "main",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "another" => [
            "controller" => "main",
            "function" => "another",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "multiple/folder" => [
            "controller" => "folders\\user",
            "function" => "folders",
            "accept" => [
                "GET"
            ]
        ],
        "welcome/puko" => [
            "controller" => "welcome",
            "function" => "puko",
            "accept" => [
                "GET",
                "POST"
            ]
        ]
    ],
    "error" => [
        "controller" => "",
        "function" => "",
        "accept" => [
            "GET"
        ]
    ],
    "not_found" => [
        "controller" => "",
        "function" => "",
        "accept" => [
            "GET"
        ]
    ]
]; return $routes;