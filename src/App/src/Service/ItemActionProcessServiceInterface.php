<?php


namespace App\Service;


use App\Entity\ItemActionProcess;

interface ItemActionProcessServiceInterface
{
    public function findById(int $id): ItemActionProcess|null;

    public function findByIdProcessAndIdaction(int $idprocess, int $idaction): ItemActionProcess|null;
}
