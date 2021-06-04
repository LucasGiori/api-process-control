<?php


namespace App\Api\Handler;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Dto\UserRequest;
use App\Entity\User;
use App\Service\AuthenticationTokenServiceInterface;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\ValidationException;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostUserLoginHandler implements RequestHandlerInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private AuthenticationTokenServiceInterface $authenticationTokenServiceInterface
    ){}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            /** @var UserRequest $userLogin */
            $userLogin = $request->getAttribute("userLogin");

            /** @var User $userEntity */
            $userEntity = $request->getAttribute("userEntity");

            if(!password_verify (password: $userLogin->getPassword(), hash: $userEntity->getPassword())) {
                throw new ValidationException(
                    message: "Login ou Senha inválido",
                    statusCode: StatusHttp::EXPECTATION_FAILED
                );
            }

            $token = $this->authenticationTokenServiceInterface->createUserToken(user: $userEntity);

            return new JsonResponseCore(data: $token, statusCode: StatusHttp::OK);
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
