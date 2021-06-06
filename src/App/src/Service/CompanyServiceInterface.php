<?php


namespace App\Service;


use App\Entity\Company;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface CompanyServiceInterface
{
    public function findById(int $id): Company|null;

    public function findByCnpj(string $cnpj): Company|null;

    public function findByIdAndIdtypecompany(int $id, int $idtypecompany): Company|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;

    public function save(Company $company): void;

    public function update(Company $company):Company;

    public function delete(Company $company):void;
}
