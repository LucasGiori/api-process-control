<?php


namespace App\Repository;

use App\Entity\User;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

interface UserRepositoryInterface
{
    public function findById(int $id): User|null;

    public function findByLogin(string $login): User|null;

    public function findByCpf(string $cpf): User|null;

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null;

    public function save(User $user): void;

    public function update(User $user): User;
}
