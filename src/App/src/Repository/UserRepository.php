<?php


namespace App\Repository;


use App\Dto\UserResponse;
use App\Entity\User;
use App\Exceptions\SaveUserException;
use App\Exceptions\UpdateUserException;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\DBAL\Exception\SyntaxErrorException;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;
use Exception;
use Http\StatusHttp;

class UserRepository extends PaginatedRepository implements UserRepositoryInterface
{

    /**
     * @return User|object|null
     */
    public function findById(int $id): User|null
    {
        return $this->find($id);
    }

    /**
     * @return User|object|null
     */
    public function findByLogin(string $login): User|null
    {
        return $this->findOneBy([
            "login" => $login
        ]);
    }

    /**
     * @return User|object|null
     */
    public function findByCpf(string $cpf): User|null
    {
        return $this->findOneBy([
            "cpf" => $cpf
        ]);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $filter);
    }

    public function save(User $user): void
    {
        try {
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
        } catch (ConstraintViolationException $e) {
            throw new SaveUserException(
                message: "Não foi possível cadastrar o usuário uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new UpdateUserException(
                message: "Não foi possível cadastrar o usuário.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }

    public function update(User $user): User
    {
        try {
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            return $user;
        } catch (ConstraintViolationException $e) {
            throw new SaveUserException(
                message: "Não foi possível atualizar a empresa uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new UpdateUserException(
                message: "Não foi possível cadastrar a Empresa.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }
}
