<?php


namespace App\Repository;


use App\Entity\ItemActionProcess;
use DoctrinePagination\ORM\PaginatedRepository;

class ItemActionProcessProcessRepository extends PaginatedRepository implements ItemActionProcessRepositoryInterface
{
    /**
     * @return ItemActionProcess|object|null
     */
    public function findById(int $id): ItemActionProcess|null
    {
        return $this->find($id);
    }

    /**
     * @return ItemActionProcess|object|null
     */
    public function findByIdProcessAndIdaction(int $idprocess, int $idaction): ItemActionProcess|null
    {
        return $this->findOneBy(
            [
                "idaction" => $idaction,
                "idprocess" => $idprocess
            ]
        );
    }
}
