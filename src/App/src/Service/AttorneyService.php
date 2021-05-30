<?php


namespace App\Service;


use App\Entity\Attorney;
use App\Repository\AttorneyRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class AttorneyService implements AttorneyServiceInterface
{
    public function __construct(
        private AttorneyRepositoryInterface $attorneyRepositoryInterface
    ){}

    public function findById(int $id): Attorney|null
    {
        return $this->attorneyRepositoryInterface->findById(id: $id);
    }

    public function findByCpf(string $cpf): Attorney|null
    {
        return $this->attorneyRepositoryInterface->findByCpf(cpf: $cpf);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->attorneyRepositoryInterface->findWithPagination(filter: $filter);
    }

    public function save(Attorney $attorney): void
    {
        $this->attorneyRepositoryInterface->save(attorney: $attorney);
    }

    public function update(Attorney $attorney): Attorney
    {
        return $this->attorneyRepositoryInterface->update(attorney: $attorney);
    }
}
