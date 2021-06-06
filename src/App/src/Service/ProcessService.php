<?php


namespace App\Service;


use App\Entity\Process;
use App\Repository\ProcessRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class ProcessService implements ProcessServiceInterface
{
    public function __construct(
        private ProcessRepositoryInterface $processRepositoryInterface
    ){}

    public function findById(int $id): Process|null
    {
        return $this->processRepositoryInterface->findById(id: $id);
    }

    public function findByNumberAndIdcompany(string $number, int $idcompany): Process|null
    {
        return $this->processRepositoryInterface->findByNumberAndIdcompany(number: $number, idcompany: $idcompany);
    }

    public function findWithPagination(Params $params): PaginatedArrayCollection|null
    {
        return $this->processRepositoryInterface->findWithPagination(params: $params);
    }

    public function save(Process $process): Process
    {
        return $this->processRepositoryInterface->save(process: $process);
    }

    public function update(Process $process): Process
    {
        return $this->processRepositoryInterface->update(process: $process);
    }
}
