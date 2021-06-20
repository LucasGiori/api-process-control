<?php

declare(strict_types=1);

use Doctrine\DBAL\Driver\PDO\PgSQL\Driver;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'driverClass' => Driver::class,
                    'charset'     => getenv('CHARSET_DB'),
                    'host'        => getenv('CONTAINER_HOST_DB'),
                    'port'        => '5432',//getenv('PORT_DB'),
                    'user'        => getenv('POSTGRES_USER'),
                    'password'    => getenv('POSTGRES_PASSWORD'),
                    'dbname'      => getenv('POSTGRES_DB'),
                ],
            ],
        ],
        'driver'     => [
            'orm_default'       => [
                'class'   => MappingDriverChain::class,
                'drivers' => [
                    'App\Entity'               => 'app_entity'
                ],
            ],
            'app_entity'        => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../../src/App/src/Entity']
            ]
        ],
    ],
];
