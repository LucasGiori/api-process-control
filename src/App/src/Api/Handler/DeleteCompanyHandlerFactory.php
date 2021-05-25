<?php


namespace App\Api\Handler;


use App\Service\CompanyService;
use Psr\Container\ContainerInterface;

class DeleteCompanyHandlerFactory
{
    public function __invoke(ContainerInterface $container): DeleteCompanyHandler
    {
        $companyService = $container->get(CompanyService::class);

        return new DeleteCompanyHandler(companyServiceInterface: $companyService);
    }
}
