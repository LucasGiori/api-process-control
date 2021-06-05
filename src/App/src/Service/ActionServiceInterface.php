<?php


namespace App\Service;


use App\Entity\Action;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface ActionServiceInterface
{
    public function findById(int $id): Action|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;

    public function save(Action $action): void;

    public function update(Action $action): Action;
}
