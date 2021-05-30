<?php


namespace App\Api\Middleware;


use App\Service\CityService;
use App\Service\CompanyService;
use App\Service\SituationService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PostAttorneyMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PostAttorneyMiddleware
    {
        $validator                   = $container->get(ValidationSymfony::class);
        $deserialization             = $container->get(Deserialization::class);
        $cityService                 = $container->get(CityService::class);
        $situationService            = $container->get(SituationService::class);
        $companyService              = $container->get(CompanyService::class);

        return new PostAttorneyMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            cityServiceInterface: $cityService,
            situationServiceInterface: $situationService,
            companyServiceInterface: $companyService
        );
    }
}
