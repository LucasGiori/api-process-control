<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetProcessMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): GetProcessMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetProcessMiddleware(queryParamsValidator: $queryParamsValidation);
    }
}
