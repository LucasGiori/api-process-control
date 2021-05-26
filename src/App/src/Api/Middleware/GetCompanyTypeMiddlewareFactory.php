<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetCompanyTypeMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): GetCompanyTypeMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetCompanyTypeMiddleware(queryParamsValidator: $queryParamsValidation);
    }
}
