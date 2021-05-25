<?php


namespace App\Repository;


use App\Entity\Situation;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;

class SituationRepository extends PaginatedRepository implements SituationRepositoryInterface
{
    /**
     * @return Situation|object|null
     */
    public function findById(int $id): Situation|null
    {
        return $this->find($id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $filter);
    }
}
