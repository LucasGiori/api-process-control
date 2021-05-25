<?php


namespace App\Repository;


use App\Entity\Company;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface CompanyRepositoryInterface
{
    public function findById(int $id): Company|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;

    public function save(Company $company): void;

    public function update(Company $company):Company;

    public function delete(Company $company):void;
}
