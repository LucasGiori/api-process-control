<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Dto\UserRequest;
use App\Service\UserServiceInterface;
use App\Utils\Validation\NotNull;
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

class PostUserLoginMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private DeserializationInterface $deserialization,
        private ValidationSymfonyInterface $validation,
        private UserServiceInterface $userServiceInterface
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $body = $request->getBody()->getContents();

            ValidationBody::emptyBody(body: $body);

            /** @var UserRequest $userRequest */
            $userRequest = $this->deserialization->deserialize(
                body: $body,
                entityName: UserRequest::class,
                format: "json",
                messageError: "erro ao tentar definir dados da requisição na entidade userLogin!"
            );

            $messageError = $this->validation->validateAllFieldsEntity(entityOrObject: $userRequest);

            if (!empty($messageError)) {
                throw new SymfonyValidationException(message: $messageError, statusCode: StatusHttp::EXPECTATION_FAILED);
            }

            $userEntity = $this->userServiceInterface->findByLogin(login: $userRequest->getLogin());
            NotNull::validate(value: $userEntity, message: "Login ou Senha inválido");

            if(!$userEntity->getStatus()) {
                throw new ValidationException(
                    message: "Usuário inválido ou desativado",
                    statusCode: StatusHttp::UNAUTHORIZED
                );
            }

            return $handler->handle(
                $request
                    ->withAttribute("userLogin", $userRequest)
                    ->withAttribute("userEntity", $userEntity)
            );
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
