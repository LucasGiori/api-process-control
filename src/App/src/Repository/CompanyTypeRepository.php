<?php


namespace App\Repository;


use App\Entity\CompanyType;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;

class CompanyTypeRepository extends PaginatedRepository implements CompanyTypeRepositoryInterface
{
    /**
     * @return CompanyType|object|null
     */
    public function findById(int $id): CompanyType|null
    {
        return $this->find($id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $filter);
    }
}
