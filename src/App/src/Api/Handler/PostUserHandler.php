<?php


namespace App\Api\Handler;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\User;
use App\Service\UserServiceInterface;
use Http\StatusHttp;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostUserHandler implements RequestHandlerInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private UserServiceInterface $userServiceInterface
    ){}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            /** @var User $user */
            $user = $request->getAttribute("user");

            $this->userServiceInterface->save(user: $user);

            return new JsonResponseCore(
                data: ["message"=>"Usuário cadastrado com sucesso!"],
                statusCode: StatusHttp::CREATED
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
