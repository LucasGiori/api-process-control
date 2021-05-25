<?php


namespace App\Service;


use App\Entity\CompanyType;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class CompanyTypeServiceFactory
{
    public function __invoke(ContainerInterface $container): CompanyTypeService
    {
        $entityManager    = $container->get(EntityManager::class);
        $companyTypeRepository =  $entityManager->getRepository(CompanyType::class);

        return new CompanyTypeService(companyTypeRepositoryInterface: $companyTypeRepository);

    }
}
