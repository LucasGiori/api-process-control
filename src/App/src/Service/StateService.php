<?php


namespace App\Service;

use App\Repository\StateRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class StateService implements StateServiceInterface
{
    public function __construct(
        private StateRepositoryInterface $stateRepositoryInterface
    ){}
    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->stateRepositoryInterface->findWithPagination(filter: $filter);
    }
}
