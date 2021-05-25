<?php


namespace App\Service;


use App\Entity\Company;
use App\Repository\CompanyRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class CompanyService implements CompanyServiceInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface
    ){}

    public function findById(int $id): Company|null
    {
        return $this->companyRepositoryInterface->findById(id: $id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->companyRepositoryInterface->findWithPagination(filter: $filter);
    }

    public function save(Company $company): void
    {
        $this->companyRepositoryInterface->save(company: $company);
    }

    public function update(Company $company): Company
    {
        return $this->companyRepositoryInterface->update(company: $company);
    }

    public function delete(Company $company): void
    {
        $this->companyRepositoryInterface->delete(company: $company);
    }
}
