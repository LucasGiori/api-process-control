<?php


namespace App\Repository;


use App\Entity\Attorney;
use App\Exceptions\SaveAttorneyException;
use App\Exceptions\UpdateAttorneyException;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\DBAL\Exception\SyntaxErrorException;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;
use Exception;
use Http\StatusHttp;

class AttorneyRepository extends PaginatedRepository implements AttorneyRepositoryInterface
{
    /**
     * @return Attorney|object|null
     */
    public function findById(int $id): Attorney|null
    {
        return $this->find($id);
    }

    /**
     * @return Attorney|object|null
     */
    public function findByCpf(string $cpf): Attorney|null
    {
        return $this->findOneBy([
            "cpf" => $cpf
        ]);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $filter);
    }

    public function save(Attorney $attorney): void
    {
        try {
            $this->getEntityManager()->persist($attorney);
            $this->getEntityManager()->flush();
        } catch (ConstraintViolationException $e) {
            throw new SaveAttorneyException(
                message: "Não foi possível cadastrar o advogado uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new SaveAttorneyException(
                message: "Não foi possível cadastrar o advogado.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }

    public function update(Attorney $attorney): Attorney
    {
        try {
            $this->getEntityManager()->persist($attorney);
            $this->getEntityManager()->flush();

            return $attorney;
        } catch (ConstraintViolationException $e) {
            throw new UpdateAttorneyException(
                message: "Não foi possível atualizar o advogado foi violada uma constraint!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new UpdateAttorneyException(
                message: "Não foi possível atualizar o advogado.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }
}
