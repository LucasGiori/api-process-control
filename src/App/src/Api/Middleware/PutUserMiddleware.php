<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\User;
use App\Service\UserServiceInterface;
use App\Service\UserTypeServiceInterface;
use App\Utils\Constants;
use App\Utils\Validation\NotNull;
use DateTime;
use Http\StatusHttp;
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

class PutUserMiddleware implements MiddlewareInterface
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
            $iduser = intval($request->getAttribute("id"));

            $tokenData = $request->getAttribute("token");

            if($tokenData["userData"]["id"] !== $iduser && $tokenData["userData"]["type"] !== Constants::USERTYPE_ADMIN) {
                throw new ValidationException(
                    message: "Usuário sem permissão para atualizar dados de outro usuário!",
                    statusCode: StatusHttp::UNAUTHORIZED
                );
            }

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
                fieldsToValidate: ValidationArrayKeys::validJsonAndReturnArrayKeys(json: $body),
                entityOrObject: $userRequest
            );

            if (!empty($messageError)) {
                throw new SymfonyValidationException(message: $messageError,statusCode: StatusHttp::EXPECTATION_FAILED);
            }

            $userEntity = $this->userServiceInterface->findById(id: $iduser);
            NotNull::validate(value: $userEntity,message: "Não existe nenhum usuário com este identificador");

            if(
                !is_null($userRequest?->getUserType()?->getId())
                && $tokenData["userData"]["type"] === Constants::USERTYPE_ADMIN
            ) {
                $userType = $this->userTypeServiceInterface->findById(id: $userRequest->getUserType()->getId());
                NotNull::validate(value: $userType, message: "Não existe nenhum tipo de usuário com este identificador!");

                $userEntity->setUserType(userType: $userType);
            }

            if(!is_null($userRequest?->getPassword())) {
                $userEntity->setPassword(
                    password:  password_hash(password: $userRequest->getPassword(), algo: PASSWORD_BCRYPT)
                );
            }

            $userEntity->setStatus(status: $userRequest?->getStatus() ?? $userEntity->getStatus());
            $userEntity->setUpdatedAt(updatedAt: new DateTime());
            $userEntity->setName(name: $userRequest?->getName() ?? $userEntity->getName());
            $userEntity->setEmail(email: $userRequest?->getEmail() ?? $userEntity->getEmail());

            return $handler->handle($request->withAttribute("user", $userEntity));
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
