<?php


namespace App\Repository;


use App\Entity\Process;
use App\Entity\ProcessMovement;
use App\Exceptions\SaveProcessException;
use App\Exceptions\UpdateProcessException;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\DBAL\Exception\SyntaxErrorException;
use DoctrinePagination\Collection\PaginatedArrayCollection;
use DoctrinePagination\DTO\Params;
use DoctrinePagination\ORM\PaginatedRepository;
use Exception;
use Http\StatusHttp;

class ProcessRepository extends PaginatedRepository implements ProcessRepositoryInterface
{

    /**
     * @return Process|object|null
     */
    public function findById(int $id): Process|null
    {
        return $this->find($id);
    }

    /**
     * @return Process|object|null
     */
    public function findByNumberAndIdcompany(string $number, int $idcompany): Process|null
    {
        return $this->findOneBy([
            "number" => $number,
            "company" => $idcompany
        ]);
    }

    public function findWithPagination(Params $params): PaginatedArrayCollection|null
    {
        return $this->findPageWithDTO(params: $params);
    }

    public function save(Process $process): Process
    {
        try {
            $movements = $process->getMovements();
            $process->setMovements(movements: null);

            $items = $process->getItems();
            $process->setItems(items: null);

            $this->getEntityManager()->persist($process);
            $this->getEntityManager()->flush();

            /** @var ProcessMovement $item */
            foreach($movements->toArray() as $item) {
                $item->setProcess(process: $process);
                $this->getEntityManager()->persist($item);
                $this->getEntityManager()->flush();
            }

            foreach ($items->toArray() as $itemActionProcess) {
                $itemActionProcess->setProcess(process: $process);
                $this->getEntityManager()->persist($itemActionProcess);
                $this->getEntityManager()->flush();
            }
            return $process;
        } catch (ConstraintViolationException $e) {
            throw new SaveProcessException(
                message: "N??o foi poss??vel cadastrar o processo, uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new SaveProcessException(
                message: "N??o foi poss??vel cadastrar o processo.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }

    public function update(Process $process): Process
    {
        try {
//            $items = $process->getItems();
//            $process->setItems(items: null);

            $this->getEntityManager()->persist($process);
            $this->getEntityManager()->flush();

//            foreach ($items->toArray() as $itemActionProcess) {
//                $itemActionProcess->setProcess(process: $process);
//                $this->getEntityManager()->persist($itemActionProcess);
//                $this->getEntityManager()->flush();
//            }

            return $process;
        } catch (ConstraintViolationException $e) {
            throw new UpdateProcessException(
                message: "N??o foi poss??vel atualizar o processo, uma constraint foi violada!",
                statusCode: StatusHttp::CONFLICT,
                internalMessageError: $e->getMessage()
            );
        } catch (SyntaxErrorException | Exception $e) {
            throw new UpdateProcessException(
                message: "N??o foi poss??vel atualizar o usu??rio.",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }
}
