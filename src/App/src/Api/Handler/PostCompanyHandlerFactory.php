<?php


namespace App\Api\Handler;


use App\Service\CompanyService;
use Psr\Container\ContainerInterface;

class PostCompanyHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostCompanyHandler
    {
        $companyService = $container->get(CompanyService::class);

        return new PostCompanyHandler(companyServiceInterface: $companyService);
    }
}
