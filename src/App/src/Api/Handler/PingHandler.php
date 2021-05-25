<?php

declare(strict_types=1);

namespace App\Api\Handler;

use ApiCore\Response\JsonResponseCore;
use Http\StatusHttp;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function time;

class PingHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponseCore(data:['ack' => time()], statusCode: StatusHttp::OK);
    }
}
