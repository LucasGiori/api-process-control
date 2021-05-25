<?php

declare(strict_types=1);

namespace App\Api\Handler;

use ApiCore\Response\JsonResponseCore;
use Http\StatusHttp;
use Infrastructure\Utils\ApiConstants;
use PHPUnit\Framework\MockObject\Api;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HomePageHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $server = $_SERVER["SERVER_NAME"] ?? null;

        $documentation = match ($server) {
            ApiConstants::SERVER_NAME_DEVELOPMENT => ApiConstants::DOCUMENTATION_API_DEVELOPMENT,
            ApiConstants::SERVER_NAME_HOMOLOGATION => ApiConstants::DOCUMENTATION_API_HOMOLOGATION,
            ApiConstants::SERVER_NAME_PRODUCTION => ApiConstants::DOCUMENTATION_API_PRODUCTION,
            default => ApiConstants::DOCUMENTATION_API_DEVELOPMENT,
        };

        return new JsonResponseCore(
            data: [
                'project'       => 'API Process Control',
                'documentation' => $documentation,
                'versions'      => [
                    'v1',
                ]
            ],
            statusCode: StatusHttp::OK
        );
    }
}
