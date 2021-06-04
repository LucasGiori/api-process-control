<?php


namespace App\Service;


use App\Entity\UserType;
use App\Repository\UserTypeRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class UserTypeService implements UserTypeServiceInterface
{
    public function __construct(
        private UserTypeRepositoryInterface $userTypeRepositoryInterface
    ){}

    public function findById(int $id): UserType|null
    {
        return $this->userTypeRepositoryInterface->findById(id: $id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->userTypeRepositoryInterface->findWithPagination(filter: $filter);
    }
}
