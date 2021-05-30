<?php


namespace App\Api\Middleware;


use App\Service\AttorneyService;
use App\Service\CityService;
use App\Service\CompanyService;
use App\Service\SituationService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PutAttorneyMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PutAttorneyMiddleware
    {
        $validator                   = $container->get(ValidationSymfony::class);
        $deserialization             = $container->get(Deserialization::class);
        $cityService                 = $container->get(CityService::class);
        $situationService            = $container->get(SituationService::class);
        $companyService              = $container->get(CompanyService::class);
        $attorneyService             = $container->get(AttorneyService::class);

        return new PutAttorneyMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            cityServiceInteface: $cityService,
            situationServiceInterface: $situationService,
            companyServiceInterface: $companyService,
            attorneyServiceInterface: $attorneyService
        );
    }
}
