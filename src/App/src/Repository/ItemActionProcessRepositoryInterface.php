<?php


namespace App\Repository;


use App\Entity\ItemActionProcess;

interface ItemActionProcessRepositoryInterface
{
    public function findById(int $id): ItemActionProcess|null;

    public function findByIdProcessAndIdaction(int $idprocess, int $idaction): ItemActionProcess|null;
}
