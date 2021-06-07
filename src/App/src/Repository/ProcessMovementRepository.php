<?php


namespace App\Repository;


use App\Entity\ProcessMovement;
use App\Exceptions\SaveProcessMovementException;
use App\Exceptions\UpdateProcessMovementException;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\DBAL\Exception\SyntaxErrorException;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;
use Exception;
use Http\StatusHttp;

class ProcessMovementRepository extends PaginatedRepository implements ProcessMovementRepositoryInterface
{
    /**
     * @return ProcessMovement|object|null
     */
    public function findById(int $id): ProcessMovement|null
    {
        return $this->find($id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $filter);
    }

    /**
     * @return ProcessMovement|object|null
     */
    public function findLastMoveByIdprocess(int $idprocess): ProcessMovement|null
    {
        return $this->findOneBy(
            criteria: [
                "process" => $idprocess
            ],
            orderBy: [
                "id" => "desc"
            ]
        );
    }

    public function save(ProcessMovement $processMovement): ProcessMovement
    {
        try {
            $this->getEntityManager()->persist($processMovement);
            $this->getEntityManager()->flush();

            return $processMovement;
        } catch (ConstraintViolationException $e) {
            throw new SaveProcessMovementException(
                message: "Não foi possível cadastrar a movimentação do processo, uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new SaveProcessMovementException(
                message: "Não foi possível cadastrar a movimentação do processo.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }

    public function update(ProcessMovement $processMovement): ProcessMovement
    {
        try {
            $this->getEntityManager()->persist($processMovement);
            $this->getEntityManager()->flush();

            return $processMovement;
        } catch (ConstraintViolationException $e) {
            throw new UpdateProcessMovementException(
                message: "Não foi possível atualizar a movimentação do processo, uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new UpdateProcessMovementException(
                message: "Não foi possível atualizar a movimentação do processo.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }
}
