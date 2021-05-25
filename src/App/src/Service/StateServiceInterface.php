<?php

namespace App\Service;

use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface StateServiceInterface
{
    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;
}
