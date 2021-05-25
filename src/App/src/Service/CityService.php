<?php


namespace App\Service;


use App\Entity\City;
use App\Repository\CityRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class CityService implements CityServiceInterface
{
    public function __construct(
        private CityRepositoryInterface $cityRepositoryInterface
    ){}

    public function findById(int $id): City|null
    {
        return $this->cityRepositoryInterface->findById(id: $id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->cityRepositoryInterface->findWithPagination(filter: $filter);
    }
}
