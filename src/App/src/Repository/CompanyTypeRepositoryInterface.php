<?php


namespace App\Repository;


use App\Entity\CompanyType;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface CompanyTypeRepositoryInterface
{
    public function findById(int $id): CompanyType|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;
}
