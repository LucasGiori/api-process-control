<?php


namespace App\Service;


use App\Entity\City;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class CityServiceFactory
{
    public function __invoke(ContainerInterface $container): CityService
    {
        $entityManager    = $container->get(EntityManager::class);
        $cityRepository =  $entityManager->getRepository(City::class);

        return new CityService(cityRepositoryInterface: $cityRepository);
    }
}
