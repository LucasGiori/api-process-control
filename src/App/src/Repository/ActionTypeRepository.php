<?php


namespace App\Repository;


use App\Entity\ActionType;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;

class ActionTypeRepository extends PaginatedRepository implements ActionTypeRepositoryInterface
{
    /**
     * @return ActionType|object|null
     */
    public function findById(int $id): ActionType
    {
        return $this->find($id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $filter);
    }
}
