<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetUserMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): GetUserMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetUserMiddleware(queryParamsValidator: $queryParamsValidation);
    }
}
