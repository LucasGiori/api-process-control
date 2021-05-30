<?php


namespace App\Service;


use App\Entity\Attorney;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class AttorneyServiceFactory
{
    public function __invoke(ContainerInterface $container): AttorneyService
    {
        $entityManager    = $container->get(EntityManager::class);
        $attorneyRepository =  $entityManager->getRepository(Attorney::class);

        return new AttorneyService(attorneyRepositoryInterface: $attorneyRepository);
    }
}
