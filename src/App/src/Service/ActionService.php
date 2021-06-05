<?php


namespace App\Service;


use App\Entity\Action;
use App\Repository\ActionRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class ActionService implements ActionServiceInterface
{
    public function __construct(
        private ActionRepositoryInterface $actionRepositoryInterface
    ){}

    public function findById(int $id): Action|null
    {
        return $this->actionRepositoryInterface->findById(id: $id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->actionRepositoryInterface->findWithPagination(filter: $filter);
    }

    public function save(Action $action): void
    {
        $this->actionRepositoryInterface->save(action: $action);
    }

    public function update(Action $action): Action
    {
       return $this->actionRepositoryInterface->update(action: $action);
    }
}
