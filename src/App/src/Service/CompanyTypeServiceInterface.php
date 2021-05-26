<?php


namespace App\Service;


use App\Entity\CompanyType;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface CompanyTypeServiceInterface
{
    public function findById(int $id): CompanyType|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;
}
