<?php


namespace App\Service;


use App\Entity\UserType;

interface UserTypeServiceInterface
{
    public function findById(int $id): UserType|null;
}
