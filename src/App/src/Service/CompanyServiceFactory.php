<?php


namespace App\Service;


use App\Entity\Company;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class CompanyServiceFactory
{
    public function __invoke(ContainerInterface $container): CompanyService
    {
        $entityManager    = $container->get(EntityManager::class);
        $companyRepository =  $entityManager->getRepository(Company::class);

        return new CompanyService(companyRepositoryInterface: $companyRepository);
    }
}
