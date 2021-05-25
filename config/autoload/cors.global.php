<?php

use Infrastructure\Container\CorsMiddlewareFactory;
use Tuupola\Middleware\CorsMiddleware;

return [
    "cors"         => [
        "origin"         => ["*"],
        "methods"        => ["GET", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
        "headers.allow"  => [
            "Origin",
            "Content-Type",
            "Authorization",
            "Accept",
            "ignoreLoadingBar",
            "X-Requested-With",
            "Access-Control-Allow-Origin",
        ],
        "headers.expose" => [],
        "credentials"    => false,
        "cache"          => 0,
    ],
    "dependencies" => [
        "factories" => [
            CorsMiddleware::class => CorsMiddlewareFactory::class,
        ],
    ],
];
