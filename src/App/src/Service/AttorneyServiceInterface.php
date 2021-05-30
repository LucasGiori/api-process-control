<?php


namespace App\Service;


use App\Entity\Attorney;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface AttorneyServiceInterface
{
    public function findById(int $id): Attorney|null;

    public function findByCpf(string $cpf): Attorney|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;

    public function save(Attorney $attorney): void;

    public function update(Attorney $attorney): Attorney;
}
