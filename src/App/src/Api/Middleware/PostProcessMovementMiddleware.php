<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Process;
use App\Entity\ProcessMovement;
use App\Service\AttorneyServiceInterface;
use App\Service\CompanyServiceInterface;
use App\Service\ProcessServiceInterface;
use App\Service\UserServiceInterface;
use App\Utils\Constants;
use App\Utils\Validation\NotNull;
use DateTime;
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
use Throwable;

class PostProcessMovementMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private DeserializationInterface $deserialization,
        private ValidationSymfonyInterface $validation,
        private ProcessServiceInterface $processServiceInterface,
        private CompanyServiceInterface $companyServiceInterface,
        private AttorneyServiceInterface $attorneyServiceInterface,
        private UserServiceInterface $userServiceInterface
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $tokenData = $request->getAttribute("token");

            if(!isset($tokenData["userData"]["id"])) {
                throw new ValidationException(message: "Usuário inválido",statusCode: StatusHttp::UNAUTHORIZED);
            }

            $body = $request->getBody()->getContents();

            ValidationBody::emptyBody(body: $body);

            /** @var ProcessMovement $processMovementRequest */
            $processMovementRequest = $this->deserialization->deserialize(
                body: $body,
                entityName: ProcessMovement::class,
                format: "json",
                messageError: "erro ao tentar definir dados da requisição na entidade processo!"
            );

            $messageError = $this->validation->validateEntitySpecificFields(
                fieldsToValidate: ["process","office", "attorney"],
                entityOrObject: $processMovementRequest
            );

            if (!empty($messageError)) {
                throw new SymfonyValidationException(message: $messageError, statusCode: StatusHttp::EXPECTATION_FAILED);
            }

            $user = $this->userServiceInterface->findById(id: intval($tokenData["userData"]["id"]));
            if(is_null($user) || $user->getStatus() !== Constants::STATUS_ACTIVE) {
                throw new ValidationException(
                    message: "Usuario inválido ou desativado",
                    statusCode: StatusHttp::EXPECTATION_FAILED
                );
            }

            $process = $this->processServiceInterface->findById(id: $processMovementRequest->getProcess()->getId());
            NotNull::validate(value: $process, message: "Não existe nenhum processo com este identificador!");

            if($process->getStatus() !== Constants::STATUS_ACTIVE) {
                throw new ValidationException(
                    message: "O processo não está mais Ativo, não pode realizar movimentações",
                    statusCode: StatusHttp::EXPECTATION_FAILED
                );
            }

            $attorney = $this->attorneyServiceInterface->findById(id: $processMovementRequest->getAttorney()->getId());
            NotNull::validate(value: $attorney, message: "Não existe nenhum advogado com este identificador");

            $office = $this->companyServiceInterface->findByIdAndIdtypecompany(
                id: intval($processMovementRequest?->getOffice()?->getId()),
                idtypecompany: Constants::TYPE_COMPANY_OFFICE
            );
            NotNull::validate(value: $office, message: "Não existe nenhum escritório com este identificador");

            $now = new DateTime();
            $processMovementRequest->setProcess(process: $process);
            $processMovementRequest->setOffice(office: $office);
            $processMovementRequest->setAttorney(attorney: $attorney);
            $processMovementRequest->setUser(user: $user);
            $processMovementRequest->setCreatedAt(createdAt: $now);
            $processMovementRequest->setUpdatedAt(updatedAt: $now);

            return $handler->handle($request->withAttribute("processMovement", $processMovementRequest));
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
