<?php


namespace App\Api\Handler;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Process;
use App\Service\ProcessServiceInterface;
use Http\StatusHttp;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PutProcessHandler implements RequestHandlerInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private ProcessServiceInterface $processServiceInterface
    ){}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            /** @var Process $process */
            $process = $request->getAttribute("process");

            $process = $this->processServiceInterface->update(process: $process);

            return new JsonResponseCore(data: $process,statusCode: StatusHttp::OK);
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
