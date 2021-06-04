<?php

return [
    "jwt" => [
        "key"         => getenv("JWT_SERCRET_KEY"),
        "algorithm"   => getenv("JWT_ALGORITHM"),
        "tokenSource" => "header",
        "expiration"  => getenv("JWT_EXPIRATION"),
        "timezone"    => getenv("JWT_TIMEZONE"),
    ],
];
