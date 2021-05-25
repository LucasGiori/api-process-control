<?php


namespace App\Repository;


use App\Entity\City;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;

class CityRepository extends PaginatedRepository implements CityRepositoryInterface
{
    /**
     * @return City|object|null
     */
    public function findById(int $id): City|null
    {
        return $this->find($id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $filter);
    }
}
