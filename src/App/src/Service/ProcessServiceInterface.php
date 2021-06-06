<?php


namespace App\Service;


use App\Entity\Process;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface ProcessServiceInterface
{
    public function findById(int $id): Process|null;

    public function findByNumberAndIdcompany(string $number, int $idcompany): Process|null;

    public function findWithPagination(Params $params): PaginatedArrayCollection|null;

    public function save(Process $process): Process;

    public function update(Process $process): Process;
}
