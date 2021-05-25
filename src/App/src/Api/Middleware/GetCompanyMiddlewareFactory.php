<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetCompanyMiddlewareFactory
{
    public function __invoke(ContainerInterface $container):GetCompanyMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetCompanyMiddleware(queryParamsValidator: $queryParamsValidation);
    }
}
