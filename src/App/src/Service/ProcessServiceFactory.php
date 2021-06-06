<?php


namespace App\Service;


use App\Entity\Process;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class ProcessServiceFactory
{
    public function __invoke(ContainerInterface $container): ProcessService
    {
        $entityManager    = $container->get(EntityManager::class);
        $processRepository =  $entityManager->getRepository(Process::class);

        return new ProcessService(processRepositoryInterface: $processRepository);
    }
}
