<?php


namespace App\Service;


use App\Entity\UserType;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class UserTypeServiceFactory
{
    public function __invoke(ContainerInterface $container): UserTypeService
    {
        $entityManager    = $container->get(EntityManager::class);
        $userTypeRepository =  $entityManager->getRepository(UserType::class);

        return new UserTypeService(userTypeRepositoryInterface: $userTypeRepository);
    }
}
