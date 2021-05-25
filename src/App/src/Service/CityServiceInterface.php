<?php


namespace App\Service;


use App\Entity\City;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface CityServiceInterface
{
    public function findById(int $id): City|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;
}
