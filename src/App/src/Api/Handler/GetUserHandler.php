<?php


namespace App\Api\Handler;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Service\StateServiceInterface;
use App\Service\UserServiceInterface;
use Doctrine\ORM\Query;
use Http\StatusHttp;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Infrastructure\Utils\Params\MapperParamsDto;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class GetUserHandler implements RequestHandlerInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private UserServiceInterface $userServiceInterface
    ){}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $params = $request->getAttribute("params");

            $filter = MapperParamsDto::map(params: $params, hydrationMode: Query::HYDRATE_OBJECT);

            $states = $this->userServiceInterface->findWithPagination(filter: $filter);

            return new JsonResponseCore(data: $states, statusCode: StatusHttp::OK);
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
