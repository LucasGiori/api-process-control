<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetActionMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): GetActionMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetActionMiddleware(queryParamsValidator: $queryParamsValidation);
    }
}
