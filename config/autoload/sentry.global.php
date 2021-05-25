<?php

return [
    "sentry" => [
        "dsn"                     => getenv("SENTRY_URL"),
        "capture_silenced_errors" => true,
        "context_lines"           => 5,
        "max_request_body_size"   => "always",
    ],
];
