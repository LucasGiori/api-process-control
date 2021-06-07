<?php


namespace App\Api\Handler;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\ProcessMovement;
use App\Service\ProcessMovementServiceInterface;
use Http\StatusHttp;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostProcessMovementHandler implements RequestHandlerInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private ProcessMovementServiceInterface $processMovementServiceInterface
    ){}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            /** @var ProcessMovement $processMovement */
            $processMovement = $request->getAttribute("processMovement");

            $processMovement = $this->processMovementServiceInterface->save(processMovement: $processMovement);

            return new JsonResponseCore(data: $processMovement, statusCode: StatusHttp::CREATED);
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
