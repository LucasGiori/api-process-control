<?php


namespace App\Api\Handler;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Service\ProcessMovementServiceInterface;
use Doctrine\ORM\Query;
use Http\StatusHttp;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Infrastructure\Utils\Params\MapperParamsDto;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class GetProcessMovementHandler implements RequestHandlerInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private ProcessMovementServiceInterface $processMovementServiceInterface
    ){}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $params = $request->getAttribute("params");

            $filter = MapperParamsDto::map(params: $params, hydrationMode: Query::HYDRATE_OBJECT);

            $movements = $this->processMovementServiceInterface->findWithPagination(filter: $filter);

            return new JsonResponseCore(data: $movements, statusCode: StatusHttp::OK);
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
