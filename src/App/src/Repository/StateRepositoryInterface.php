<?php

namespace App\Repository;

use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface StateRepositoryInterface
{
    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;
}
