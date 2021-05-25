<?php

namespace Infrastructure\Service\Logs;

use ApiCore\Response\JsonResponseCore;
use Http\StatusHttp;
use Infrastructure\Service\Logs\Sentry\SentryServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class LogsService
{
    public function __construct(
        private SentryServiceInterface $sentryService
    ){}

    public function __invoke(
        Throwable $e,
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface
    {
        $this->sentryService->executeSendLogException(exception: $e);

        return new JsonResponseCore(data: $e->getMessage(), statusCode: StatusHttp::INTERNAL_SERVER_ERROR);
    }

}
