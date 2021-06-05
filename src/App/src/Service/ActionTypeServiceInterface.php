<?php


namespace App\Service;


use App\Entity\ActionType;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface ActionTypeServiceInterface
{
    public function findById(int $id): ActionType|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;
}
