<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetCityMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): GetCityMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetCityMiddleware(queryParamsValidator: $queryParamsValidation);
    }
}
