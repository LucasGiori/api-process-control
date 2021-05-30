<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetAttorneyMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): GetAttorneyMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetAttorneyMiddleware(queryParamsValidator: $queryParamsValidation);
    }
}
