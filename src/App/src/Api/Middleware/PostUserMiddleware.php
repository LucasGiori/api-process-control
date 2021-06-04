<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\User;
use App\Service\UserServiceInterface;
use App\Service\UserTypeServiceInterface;
use App\Utils\Validation\Cpf;
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

class PostUserMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private DeserializationInterface $deserialization,
        private ValidationSymfonyInterface $validation,
        private UserTypeServiceInterface $userTypeServiceInterface,
        private UserServiceInterface $userServiceInterface
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $body = $request->getBody()->getContents();

            ValidationBody::emptyBody(body: $body);

            /** @var User $userRequest */
            $userRequest = $this->deserialization->deserialize(
                body: $body,
                entityName: User::class,
                format: "json",
                messageError: "erro ao tentar definir dados da requisição na entidade user!"
            );

            $messageError = $this->validation->validateEntitySpecificFields(
                fieldsToValidate: ["name", "login", "email","cpf","password","userType"],
                entityOrObject: $userRequest
            );

            if (!empty($messageError)) {
                throw new SymfonyValidationException(
                    message: $messageError,
                    statusCode: StatusHttp::EXPECTATION_FAILED,
                );
            }

            //Validate Cpf is Valid:
            new Cpf(cpf: $userRequest->getCpf());

            $userType = $this->userTypeServiceInterface->findById(id: $userRequest->getUserType()->getId());
            NotNull::validate(value: $userType, message: "Não existe nenhum tipo de usuário com este identificador!");

            if(!is_null($this->userServiceInterface->findByLogin(login: $userRequest->getLogin()))) {
                throw new ValidationException(
                    message: "Já existe um usuário com este login!",
                    statusCode: StatusHttp::EXPECTATION_FAILED
                );
            }

            if(!is_null($this->userServiceInterface->findByCpf(cpf: $userRequest->getCpf()))) {
                throw new ValidationException(
                    message: "Já existe um usuário com este cpf!",
                    statusCode: StatusHttp::EXPECTATION_FAILED
                );
            }

            $now = new DateTime();
            $userRequest->setCreatedAt(createdAt: $now);
            $userRequest->setUpdatedAt(updatedAt: $now);
            $userRequest->setUserType(userType: $userType);
            $userRequest->setStatus(status: true);
            $userRequest->setPassword(
                password:  password_hash(password: $userRequest->getPassword(), algo: PASSWORD_BCRYPT)
            );

            return $handler->handle($request->withAttribute("user", $userRequest));
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
