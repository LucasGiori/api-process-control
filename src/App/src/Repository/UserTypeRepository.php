<?php


namespace App\Repository;


use App\Entity\UserType;
use Doctrine\ORM\EntityRepository;

class UserTypeRepository extends EntityRepository implements UserTypeRepositoryInterface
{
    /**
     * @return UserType|object|null
     */
    public function findById(int $id): UserType|null
    {
        return $this->find($id);
    }
}
