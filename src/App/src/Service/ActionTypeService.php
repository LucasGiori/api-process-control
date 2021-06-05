<?php


namespace App\Service;


use App\Entity\ActionType;
use App\Repository\ActionTypeRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class ActionTypeService implements ActionTypeServiceInterface
{
    public function __construct(
        private ActionTypeRepositoryInterface $actionTypeRepositoryInterface
    ){}

    public function findById(int $id): ActionType|null
    {
        return $this->actionTypeRepositoryInterface->findById(id: $id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->actionTypeRepositoryInterface->findWithPagination(filter: $filter);
    }
}
