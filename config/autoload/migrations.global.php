<?php

declare(strict_types=1);

return [
    "paths"         => [
        "migrations" => [
            sprintf("%s/../../src/App/src/Database/Migrations", __DIR__),
        ],
        "seeds"      => [
            sprintf("%s/../../src/App/src/Database/Seeds", __DIR__),
        ],
    ],
    "environments"  => [
        "default_migration_table" => "phinxlog",
        "default_environment"     => "dev",
        "dev"                     => [
            "adapter" => getenv("ADAPTER"),
            "host"    => getenv("CONTAINER_HOST_DB"),
            "port"    => '5432',//getenv("PORT_DB"),
            "user"    => getenv("POSTGRES_USER"),
            "pass"    => getenv("POSTGRES_PASSWORD"),
            "name"    => getenv("POSTGRES_DB"),
            "charset" => getenv("CHARSET_DB"),
        ],
    ],
    "version_order" => "creation",
];
