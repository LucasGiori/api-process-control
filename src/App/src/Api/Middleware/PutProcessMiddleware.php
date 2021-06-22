<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Process;
use App\Entity\ProcessMovement;
use App\Service\ActionServiceInterface;
use App\Service\AttorneyServiceInterface;
use App\Service\CompanyServiceInterface;
use App\Service\ProcessServiceInterface;
use App\Service\UserServiceInterface;
use App\Utils\Constants;
use App\Utils\Validation\NotNull;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\BaseException;
use Infrastructure\Domain\Exceptions\SymfonyValidationException;
use Infrastructure\Domain\Exceptions\ValidationException;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Infrastructure\Utils\Serializer\DeserializationInterface;
use Infrastructure\Utils\Validation\ValidationArrayKeys;
use Infrastructure\Utils\Validation\ValidationBody;
use Infrastructure\Utils\Validation\ValidationSymfonyInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PutProcessMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private DeserializationInterface $deserialization,
        private ValidationSymfonyInterface $validation,
        private UserServiceInterface $userServiceInterface,
        private ProcessServiceInterface $processServiceInterface,
        private ActionServiceInterface $actionServiceInterface
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $idprocess = intval(value: $request->getAttribute("idprocess"));

            $tokenData = $request->getAttribute("token");

            if(!isset($tokenData["userData"]["id"])) {
                throw new ValidationException(message: "Usuário inválido",statusCode: StatusHttp::UNAUTHORIZED);
            }

            $body = $request->getBody()->getContents();

            ValidationBody::emptyBody(body: $body);

            /** @var Process $processRequest */
            $processRequest = $this->deserialization->deserialize(
                body: $body,
                entityName: Process::class,
                format: "json",
                messageError: "erro ao tentar definir dados da requisição na entidade processo!"
            );

            $messageError = $this->validation->validateEntitySpecificFields(
                fieldsToValidate: ValidationArrayKeys::validJsonAndReturnArrayKeys(json: $body),
                entityOrObject: $processRequest
            );

            if (!empty($messageError)) {
                throw new SymfonyValidationException(message: $messageError, statusCode: StatusHttp::EXPECTATION_FAILED);
            }

            $user = $this->userServiceInterface->findById(id: intval($tokenData["userData"]["id"]));
            if(is_null($user) || $user->getStatus() !== Constants::STATUS_ACTIVE) {
                throw new ValidationException(
                    message: "Usuário inválido ou desativado",
                    statusCode: StatusHttp::EXPECTATION_FAILED
                );
            }

            $processEntity = $this->processServiceInterface->findById(id: $idprocess);
            NotNull::validate(value: $processEntity, message: "Não existe nenhum processo com este identficador");

            $processEntity->setUpdatedAt(updatedAt: new DateTime());
            $processEntity->setStatus(status: $processRequest?->getStatus() ?? $processEntity->getStatus());
            $processEntity->setDescription(
                description: $processRequest?->getDescription() ?? $processEntity->getDescription()
            );
            $processEntity->setNotificationDate(
                notificationDate: $processRequest?->getNotificationDate() ?? $processEntity->getNotificationDate()
            );
            $processEntity->setNumber(number: $processRequest?->getNumber() ?? $processEntity->getNumber());
            $processEntity->setObservation(
                observation: $processRequest?->getObservation() ?? $processEntity->getObservation()
            );

            if($processRequest?->getItems()) {
                $items = array_map(
                    callback: function($itemActionProcess) use ($processEntity){
                        $actionEntity = $this->actionServiceInterface->findById(id: $itemActionProcess->getAction()->getId());
                        NotNull::validate(value: $actionEntity, message: "Não existe nenhuma ação com este identificador!");

                        $itemActionProcess->setAction(action: $actionEntity);
                        $itemActionProcess->setProcess(process: $processEntity);

                        return $itemActionProcess;
                    },
                    array: $processRequest->getItems()->toArray()
                );

                $items = new ArrayCollection($items ?? []);

                $processEntity->setItems(items: $items);
            }

            return $handler->handle($request->withAttribute("process", $processEntity));
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
