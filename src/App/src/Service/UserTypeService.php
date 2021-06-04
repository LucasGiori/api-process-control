<?php


namespace App\Service;


use App\Entity\UserType;
use App\Repository\UserTypeRepositoryInterface;

class UserTypeService implements UserTypeServiceInterface
{
    public function __construct(
        private UserTypeRepositoryInterface $userTypeRepositoryInterface
    ){}

    public function findById(int $id): UserType|null
    {
        return $this->userTypeRepositoryInterface->findById(id: $id);
    }

}
