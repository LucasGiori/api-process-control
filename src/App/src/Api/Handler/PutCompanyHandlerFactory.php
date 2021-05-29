<?php


namespace App\Api\Handler;


use App\Service\CompanyService;
use Psr\Container\ContainerInterface;

class PutCompanyHandlerFactory
{
    public function __invoke(ContainerInterface $container): PutCompanyHandler
    {
        $companyService = $container->get(CompanyService::class);

        return new PutCompanyHandler(companyServiceInterface: $companyService);
    }
}
