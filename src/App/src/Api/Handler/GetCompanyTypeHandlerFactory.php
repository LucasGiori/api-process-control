<?php


namespace App\Api\Handler;


use App\Service\CompanyTypeService;
use Psr\Container\ContainerInterface;

class GetCompanyTypeHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetCompanyTypeHandler
    {
        $companyTypeService = $container->get(CompanyTypeService::class);

        return new GetCompanyTypeHandler(companyTypeServiceInterface: $companyTypeService);
    }
}
