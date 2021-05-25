<?php


namespace App\Service;


use App\Entity\State;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class StateServiceFactory
{
    public function __invoke(ContainerInterface $container): StateService
    {
        $entityManager    = $container->get(EntityManager::class);
        $stateRepository =  $entityManager->getRepository(State::class);

        return new StateService(stateRepositoryInterface: $stateRepository);
    }
}
