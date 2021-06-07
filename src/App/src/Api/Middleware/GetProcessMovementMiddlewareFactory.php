<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetProcessMovementMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): GetProcessMovementMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetProcessMovementMiddleware(queryParamsValidator: $queryParamsValidation);
    }
}
