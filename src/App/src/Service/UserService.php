<?php


namespace App\Service;


use App\Dto\UserResponse;
use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface
    ){}

    public function findById(int $id): User|null
    {
        return $this->userRepositoryInterface->findById(id: $id);
    }

    public function findByLogin(string $login): User|null
    {
        return $this->userRepositoryInterface->findByLogin(login: $login);
    }

    public function findByCpf(string $cpf): User|null
    {
        return $this->userRepositoryInterface->findByCpf(cpf: $cpf);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        $users = $this->userRepositoryInterface->findWithPagination(filter: $filter);

        $users->setData(
            data: array_map(
                callback: function($user) {
                    return new UserResponse($user->toArray());
                },
                array: $users->getData()
            )
        );

        return $users;
    }

    public function save(User $user): void
    {
        $this->userRepositoryInterface->save(user: $user);
    }

    public function update(User $user): UserResponse
    {
        $user = $this->userRepositoryInterface->update(user: $user);

        return new UserResponse(data: $user->toArray());
    }
}
