<?php


namespace App\Api\Middleware;


use App\Service\CityService;
use App\Service\CompanyService;
use App\Service\CompanyTypeService;
use App\Service\SituationService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PutCompanyMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PutCompanyMiddleware
    {
        $validator                   = $container->get(ValidationSymfony::class);
        $deserialization             = $container->get(Deserialization::class);
        $cityService                 = $container->get(CityService::class);
        $situationService            = $container->get(SituationService::class);
        $companyTypeService          = $container->get(CompanyTypeService::class);
        $companyService              = $container->get(CompanyService::class);

        return new PutCompanyMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            cityServiceInteface: $cityService,
            situationServiceInterface: $situationService,
            companyTypeServiceInterface: $companyTypeService,
            companyServiceInterface: $companyService
        );
    }
}
