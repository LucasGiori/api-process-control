<?php


namespace App\Service;


use App\Entity\ItemActionProcess;
use App\Repository\ItemActionProcessRepositoryInterface;

class ItemActionProcessService implements ItemActionProcessServiceInterface
{
    public function __construct(
        private ItemActionProcessRepositoryInterface $itemActionProcessRepositoryInterface
    ){}

    public function findById(int $id): ItemActionProcess|null
    {
        return $this->itemActionProcessRepositoryInterface->findById(id: $id);
    }

    public function findByIdProcessAndIdaction(int $idprocess, int $idaction): ItemActionProcess|null
    {
        return $this->itemActionProcessRepositoryInterface->findByIdProcessAndIdaction(
            idprocess: $idprocess,
            idaction: $idaction
        );
    }
}
