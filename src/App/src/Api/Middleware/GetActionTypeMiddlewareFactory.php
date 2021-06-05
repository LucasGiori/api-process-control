<?php


namespace App\Api\Middleware;


use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Psr\Container\ContainerInterface;

class GetActionTypeMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): GetActionTypeMiddleware
    {
        $queryParamsValidation = $container->get(QueryParamsValidation::class);

        return new GetActionTypeMiddleware(queryParamsValidator: $queryParamsValidation);
    }
}
