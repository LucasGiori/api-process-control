<?php


namespace App\Service;


use App\Entity\UserType;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface UserTypeServiceInterface
{
    public function findById(int $id): UserType|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;
}
