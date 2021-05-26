<?php


namespace App\Service;


use App\Entity\CompanyType;
use App\Repository\CompanyTypeRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class CompanyTypeService implements CompanyTypeServiceInterface
{
    public function __construct(
        private CompanyTypeRepositoryInterface $companyTypeRepositoryInterface
    ){}

    public function findById(int $id): CompanyType|null
    {
        return $this->companyTypeRepositoryInterface->findById(id: $id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->companyTypeRepositoryInterface->findWithPagination(filter: $filter);
    }
}
