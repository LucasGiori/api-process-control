<?php


namespace App\Repository;


use App\Entity\Action;
use App\Exceptions\SaveActionException;
use App\Exceptions\UpdateActionException;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\DBAL\Exception\SyntaxErrorException;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;
use Exception;
use Http\StatusHttp;

class ActionRepository extends PaginatedRepository implements ActionRepositoryInterface
{
    /**
     * @return Action|object|null
     */
    public function findById(int $id): Action|null
    {
        return $this->find($id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $filter);
    }

    public function save(Action $action): void
    {
        try {
            $this->getEntityManager()->persist($action);
            $this->getEntityManager()->flush();
        } catch (ConstraintViolationException $e) {
            throw new SaveActionException(
                message: "Não foi possível cadastrar a ação uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new SaveActionException(
                message: "Não foi possível cadastrar a ação.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }

    public function update(Action $action): Action
    {
        try {
            $this->getEntityManager()->persist($action);
            $this->getEntityManager()->flush();

            return $action;
        } catch (ConstraintViolationException $e) {
            throw new UpdateActionException(
                message: "Não foi possível atualizar a ação uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new UpdateActionException(
                message: "Não foi possível atualizar a ação.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }
}
