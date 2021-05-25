<?php


namespace App\Service;


use App\Entity\Situation;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class SituationServiceFactory
{
    public function __invoke(ContainerInterface $container): SituationService
    {
        $entityManager    = $container->get(EntityManager::class);
        $situationRepository =  $entityManager->getRepository(Situation::class);

        return new SituationService(situationRepositoryInterface: $situationRepository);
    }
}
