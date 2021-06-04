<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetUserTypeMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): GetUserTypeMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetUserTypeMiddleware(queryParamsValidator: $queryParamsValidation);
    }

}
