<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Action;
use App\Entity\ItemActionProcess;
use App\Entity\Process;
use App\Entity\ProcessMovement;
use App\Service\ActionServiceInterface;
use App\Service\AttorneyServiceInterface;
use App\Service\CompanyServiceInterface;
use App\Service\ProcessServiceInterface;
use App\Service\SituationServiceInterface;
use App\Service\UserServiceInterface;
use App\Utils\Constants;
use App\Utils\Validation\NotNull;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\SymfonyValidationException;
use Infrastructure\Domain\Exceptions\ValidationException;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Infrastructure\Utils\Serializer\DeserializationInterface;
use Infrastructure\Utils\Validation\ValidationBody;
use Infrastructure\Utils\Validation\ValidationSymfonyInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\Common\Collections\Collection;
use Throwable;

class PostProcessMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private DeserializationInterface $deserialization,
        private ValidationSymfonyInterface $validation,
        private CompanyServiceInterface $companyServiceInterface,
        private UserServiceInterface $userServiceInterface,
        private ProcessServiceInterface $processServiceInterface,
        private AttorneyServiceInterface $attorneyServiceInterface,
        private ActionServiceInterface $actionServiceInterface
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $tokenData = $request->getAttribute("token");

            if(!isset($tokenData["userData"]["id"])) {
                throw new ValidationException(message: "Usu??rio inv??lido",statusCode: StatusHttp::UNAUTHORIZED);
            }

            $body = $request->getBody()->getContents();

            ValidationBody::emptyBody(body: $body);

            /** @var Process $processRequest */
            $processRequest = $this->deserialization->deserialize(
                body: $body,
                entityName: Process::class,
                format: "json",
                messageError: "erro ao tentar definir dados da requisi????o na entidade processo!"
            );

            $messageError = $this->validation->validateEntitySpecificFields(
                fieldsToValidate: ["number", "company"],
                entityOrObject: $processRequest
            );

            if (!empty($messageError)) {
                throw new SymfonyValidationException(message: $messageError, statusCode: StatusHttp::EXPECTATION_FAILED);
            }

            $user = $this->userServiceInterface->findById(id: intval($tokenData["userData"]["id"]));
            if(is_null($user) || $user->getStatus() !== Constants::STATUS_ACTIVE) {
                throw new ValidationException(
                    message: "Usuario inv??lido ou desativado",
                    statusCode: StatusHttp::EXPECTATION_FAILED
                );
            }

            $company = $this->companyServiceInterface->findByIdAndIdtypecompany(
                id: intval($processRequest?->getCompany()?->getId()),
                idtypecompany: Constants::TYPE_COMPANY_ORDINARY
            );
            NotNull::validate(value: $company, message: "N??o existe nenhuma empresa com este identificador");

            $processDuplicate = $this->processServiceInterface->findByNumberAndIdcompany(
                number: $processRequest->getNumber(),
                idcompany: intval($processRequest?->getCompany()?->getId())
            );

            if(!is_null($processDuplicate)) {
                throw new ValidationException(
                    message: "J?? existe um processo com o mesmo identificador para esta empresa",
                    statusCode: StatusHttp::EXPECTATION_FAILED
                );
            }

            $now = new DateTime();

            /** @var ProcessMovement $movement */
            foreach($processRequest->getMovements() as $movement) {
                $messageError = $this->validation->validateEntitySpecificFields(
                    fieldsToValidate: ["office", "attorney"],
                    entityOrObject: $processRequest
                );

                if (!empty($messageError)) {
                    throw new SymfonyValidationException(message: $messageError, statusCode: StatusHttp::EXPECTATION_FAILED);
                }

                $office = $this->companyServiceInterface->findByIdAndIdtypecompany(
                    id: intval($movement?->getOffice()?->getId()),
                    idtypecompany: Constants::TYPE_COMPANY_OFFICE
                );
                NotNull::validate(value: $office, message: "N??o existe nenhum escrit??rio com este identificador");

                $attorney = $this->attorneyServiceInterface->findById(id: intval($movement?->getAttorney()?->getId()));
                NotNull::validate(value: $attorney, message: "N??o existe nenhum advogado com este Identificador!");

                $movement->setOffice(office: $office);
                $movement->setAttorney(attorney: $attorney);
                $movement->setUser(user: $user);
                $movement->setCreatedAt(createdAt: $now);
                $movement->setUpdatedAt(updatedAt: $now);
            }


            $items = array_map(
                callback: function($itemActionProcess) {
                    $actionEntity = $this->actionServiceInterface->findById(id: $itemActionProcess->getAction()->getId());
                    NotNull::validate(value: $actionEntity, message: "N??o existe nenhuma a????o com este identificador!");

                    $itemActionProcess->setAction(action: $actionEntity);

                    return $itemActionProcess;
                },
                array: $processRequest->getItems()?->toArray() ?? []
            );

            $collectionActions = new ArrayCollection($items ?? []);

            $processRequest->setItems(items: $collectionActions);
            $processRequest->setCompany(company: $company);
            $processRequest->setUser(user: $user);
            $processRequest->setStatus(status: Constants::STATUS_ACTIVE);
            $processRequest->setCreatedAt(createdAt: $now);
            $processRequest->setUpdatedAt(updatedAt: $now);
            return $handler->handle($request->withAttribute("process", $processRequest));
        } catch (Throwable $e) {
            $this->exception = $e;
            $code = $e->getCode() != 0 ? $e->getCode() : StatusHttp::INTERNAL_SERVER_ERROR;
            $error = $e instanceof ExceptionCore ? $e->getCustomError() : $e->getMessage();

            return new JsonResponseCore(data: $error, statusCode: $code);
        } finally {
            (new SentryService())->executeSendLogException(exception: $this->exception);
        }
    }
}
