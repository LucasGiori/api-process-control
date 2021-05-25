<?php


namespace App\Repository;


use App\Entity\Company;
use App\Exceptions\DeleteCompanyException;
use App\Exceptions\SaveCompanyException;
use App\Exceptions\UpdateCompanyException;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\DBAL\Exception\SyntaxErrorException;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;
use Exception;
use Http\StatusHttp;

class CompanyRepository extends PaginatedRepository implements CompanyRepositoryInterface
{
    /**
     * @return Company|object|null
     */
    public function findById(int $id): Company|null
    {
        return $this->find($id);
    }

    public function findWithPagination(Params $filter): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $filter);
    }

    public function save(Company $company): void
    {
        try {
            $this->getEntityManager()->persist($company);
            $this->getEntityManager()->flush();
        } catch (ConstraintViolationException $e) {
            throw new SaveCompanyException(
                message: "Não foi possível cadastrar a empresa já existe essa empresa cadastrada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new SaveCompanyException(
                message: "Não foi possível cadastrar a Empresa.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }

    public function update(Company $company): Company
    {
        try {
            $this->getEntityManager()->persist($company);
            $this->getEntityManager()->flush();
        } catch (ConstraintViolationException $e) {
            throw new UpdateCompanyException(
                message: "Não foi possível cadastrar a empresa uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new UpdateCompanyException(
                message: "Não foi possível cadastrar a Empresa.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }

    public function delete(Company $company): void
    {
        try {
            $this->getEntityManager()->remove($company);
            $this->getEntityManager()->flush();
        } catch (ConstraintViolationException $e) {
            throw new DeleteCompanyException(
                message: "Não foi possível deletar a empresa uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new DeleteCompanyException(
                message: "Não foi possível cadastrar a Empresa.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }
}
