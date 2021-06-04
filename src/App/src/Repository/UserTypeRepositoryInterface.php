<?php


namespace App\Repository;


use App\Entity\UserType;

interface UserTypeRepositoryInterface
{
    public function findById(int $id): UserType|null;
}
