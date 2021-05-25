<?php


namespace App\Service;


use App\Entity\CompanyType;
use App\Repository\CompanyTypeRepositoryInterface;

class CompanyTypeService implements CompanyTypeServiceInterface
{
    public function __construct(
        private CompanyTypeRepositoryInterface $companyTypeRepositoryInterface
    ){}

    public function findById(int $id): CompanyType|null
    {
        return $this->companyTypeRepositoryInterface->findById(id: $id);
    }
}
