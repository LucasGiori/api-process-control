<?php


namespace Infrastructure\Api\Middleware;


use Psr\Container\ContainerInterface;

class LoadConfigDataMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): LoadConfigDataMiddleware
    {
        return new LoadConfigDataMiddleware($container);
    }
}
