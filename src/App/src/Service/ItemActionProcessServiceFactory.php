<?php


namespace App\Service;


use App\Entity\ItemActionProcess;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class ItemActionProcessServiceFactory
{
    public function __invoke(ContainerInterface $container): ItemActionProcessService
    {
        $entityManager    = $container->get(EntityManager::class);
        $itemActionProcessRepository =  $entityManager->getRepository(ItemActionProcess::class);

        return new ItemActionProcessService(itemActionProcessRepository: $itemActionProcessRepository);
    }
}
