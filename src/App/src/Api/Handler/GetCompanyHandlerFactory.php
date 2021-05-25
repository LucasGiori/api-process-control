<?php


namespace App\Api\Handler;


use App\Service\CompanyService;
use Psr\Container\ContainerInterface;

class GetCompanyHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetCompanyHandler
    {
        $companyService = $container->get(CompanyService::class);

        return new GetCompanyHandler(companyServiceInterface: $companyService);
    }
}
