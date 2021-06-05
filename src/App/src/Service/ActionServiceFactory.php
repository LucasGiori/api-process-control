<?php


namespace App\Service;


use App\Entity\Action;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class ActionServiceFactory
{
    public function __invoke(ContainerInterface $container): ActionService
    {
        $entityManager    = $container->get(EntityManager::class);
        $actionRepository =  $entityManager->getRepository(Action::class);

        return new ActionService(actionRepositoryInterface: $actionRepository);
    }
}
