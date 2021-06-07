<?php


namespace App\Service;


use App\Entity\ProcessMovement;
use App\Repository\ProcessMovementRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class ProcessMovementService implements ProcessMovementServiceInterface
{
    public function __construct(
        private ProcessMovementRepositoryInterface $processMovementRepositoryInterface
    ){}

    public function findById(int $id): ProcessMovement|null
    {
        return $this->processMovementRepositoryInterface->findById(id: $id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->processMovementRepositoryInterface->findWithPagination(filter: $filter);
    }

    public function findLastMoveByIdprocess(int $idprocess): ProcessMovement|null
    {
        return $this->processMovementRepositoryInterface->findLastMoveByIdprocess(idprocess: $idprocess);
    }

    public function save(ProcessMovement $processMovement): ProcessMovement
    {
        return $this->processMovementRepositoryInterface->save(processMovement: $processMovement);
    }

    public function update(ProcessMovement $processMovement): ProcessMovement
    {
        return $this->processMovementRepositoryInterface->update(processMovement: $processMovement);
    }
}
