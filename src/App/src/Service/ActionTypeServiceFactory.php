<?php


namespace App\Service;


use App\Entity\ActionType;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class ActionTypeServiceFactory
{
    public function __invoke(ContainerInterface $container): ActionTypeService
    {
        $entityManager    = $container->get(EntityManager::class);
        $actionTypeRepository =  $entityManager->getRepository(ActionType::class);

        return new ActionTypeService(actionTypeRepositoryInterface: $actionTypeRepository);
    }
}
