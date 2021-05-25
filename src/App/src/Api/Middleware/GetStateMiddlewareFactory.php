<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetStateMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): GetStateMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetStateMiddleware(queryParamsValidator: $queryParamsValidation);
    }
}
