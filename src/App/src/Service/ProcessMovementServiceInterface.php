<?php


namespace App\Service;


use App\Entity\ProcessMovement;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface ProcessMovementServiceInterface
{
    public function findById(int $id): ProcessMovement|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;

    public function findLastMoveByIdprocess(int $idprocess): ProcessMovement|null;

    public function save(ProcessMovement $processMovement): ProcessMovement;

    public function update(ProcessMovement $processMovement): ProcessMovement;
}
