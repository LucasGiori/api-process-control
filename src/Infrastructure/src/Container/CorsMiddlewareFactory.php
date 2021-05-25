<?php

namespace Infrastructure\Container;

use Psr\Container\ContainerInterface;
use Tuupola\Middleware\CorsMiddleware;

class CorsMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): CorsMiddleware
    {
        $cors = $container->get("config")["cors"] ?? [];

        return new CorsMiddleware($cors);
    }
}
