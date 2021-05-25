<?php


namespace App\Repository;


use App\Entity\Situation;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface SituationRepositoryInterface
{
    public function findById(int $id): Situation|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;
}
