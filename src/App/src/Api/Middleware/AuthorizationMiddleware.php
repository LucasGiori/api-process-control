<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Exceptions\InvalidTokenException;
use App\Exceptions\NotFoundTokenException;
use App\Service\AuthenticationTokenServiceInterface;
use App\Service\UserServiceInterface;
use App\Utils\Validation\NotNull;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\ValidationException;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class AuthorizationMiddleware implements MiddlewareInterface
{
    public const ADMIN = 1;

    private Throwable|null $exception = null;

    public function __construct(
        private AuthenticationTokenServiceInterface $authenticationTokenServiceInterface,
        private UserServiceInterface $userServiceInterface
    ){}


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $keyRequest = $request->getHeader("authorization") ?? null;

            if(empty($keyRequest)) {
                throw new NotFoundTokenException(message: "Token Não encontrado", statusCode: StatusHttp::UNAUTHORIZED);
            }

            [$jwtToken] = sscanf($keyRequest[0], "Bearer %s");

            if (empty($jwtToken)) {
                throw new InvalidTokenException(
                    message: "O token de acesso está inválido",
                    statusCode: StatusHttp::UNAUTHORIZED
                );
            }

            $tokenDecoded = $this->authenticationTokenServiceInterface->decode(jwtToken: $jwtToken);

            $tokenData =  [
                $tokenDecoded?->data,
                $tokenDecoded?->data?->iduser,
                $tokenDecoded?->data?->name,
                $tokenDecoded?->data?->login
            ];

            if(in_array(needle: null, haystack: $tokenData)) {
                throw new InvalidTokenException(
                    message: "O token de acesso está inválido",
                    statusCode: StatusHttp::UNAUTHORIZED
                );
            }

            $user = $this->userServiceInterface->findById(id: intval($tokenDecoded->data->iduser));
            NotNull::validate(
                value: $user,
                statusCode: StatusHttp::UNAUTHORIZED,
                message: "O token de acesso é inválido"
            );

            $validate = fn($expected, $value) => $expected === $value;

            $validations = [
                $validate(expected: $user->getLogin(),value: $tokenDecoded?->data?->login),
                $validate(expected: $user->getName(), value: $tokenDecoded?->data?->name)
            ];

            if(in_array(needle: false, haystack: $validations)) {
                throw new ValidationException(
                    message: "O token de acesso é inválido",
                    statusCode: StatusHttp::UNAUTHORIZED
                );
            }

            if(
                $request->getUri()->getPath() === "/users"
                && in_array(needle: $request->getMethod(),haystack: ["POST","GET","DELETE"])
                && $user->getUserType()->getId() !== self::ADMIN) {
                throw new ValidationException(
                    message: "Este usuário não tem pemissão, para esta funcionalidade!",
                    statusCode: StatusHttp::UNAUTHORIZED
                );
            }

            $token = [
                "decoded" => $tokenDecoded,
                "encoded" => $keyRequest[0],
                "userData" => [
                    "id" => $user->getId(),
                    "type" => $user->getUserType()->getId(),
                    "email" => $user->getEmail()
                ]
            ];

            return $handler->handle($request->withAttribute("token", $token));
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
