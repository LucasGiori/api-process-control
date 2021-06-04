<?php


namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class UserServiceFactory
{
    public function __invoke(ContainerInterface $container): UserService
    {
        $entityManager    = $container->get(EntityManager::class);
        $userRepository =  $entityManager->getRepository(User::class);

        return new UserService(userRepositoryInterface: $userRepository);
    }
}
