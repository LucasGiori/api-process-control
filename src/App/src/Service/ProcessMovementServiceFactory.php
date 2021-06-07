<?php


namespace App\Service;


use App\Entity\ProcessMovement;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class ProcessMovementServiceFactory
{
    public function __invoke(ContainerInterface $container): ProcessMovementService
    {
        $entityManager    = $container->get(EntityManager::class);
        $processMovementRepository =  $entityManager->getRepository(ProcessMovement::class);

        return new ProcessMovementService(processMovementRepositoryInterface: $processMovementRepository);
    }
}
