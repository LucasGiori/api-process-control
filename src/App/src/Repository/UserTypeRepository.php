<?php


namespace App\Repository;


use App\Entity\UserType;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;

class UserTypeRepository extends PaginatedRepository implements UserTypeRepositoryInterface
{
    /**
     * @return UserType|object|null
     */
    public function findById(int $id): UserType|null
    {
        return $this->find($id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $filter);
    }
}
