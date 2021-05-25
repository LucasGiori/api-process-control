<?php

namespace InfrastructureTest\BaseTest;

use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;

class BaseAssert extends Assert
{
    public static function assertJsonResponse(ResponseInterface $response, int $statusCodeExpected)
    {
        $contentType = $response->getHeaders()["Content-Type"][0];

        self::assertStatusCode(expected: $statusCodeExpected, actual: $response->getStatusCode());
        self::assertContentType(expected: "application/json", actual: $contentType);
    }

    public static function assertContentType(string $expected, string $actual, string $message="O content-type está diferente")
    {
        self::assertEquals(expected: $expected, actual: $actual, message: $message);
    }

    public static function assertStatusCode(int $expected, int $actual, string $message="O StatusCode está diferente")
    {
        self::assertEquals(expected: $expected, actual: $actual, message: $message);
    }
}
