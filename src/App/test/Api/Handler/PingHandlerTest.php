<?php

declare(strict_types=1);

namespace AppTest\Api\Handler;

use ApiCore\Response\JsonResponseCore;
use App\Api\Handler\PingHandler;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;

use function json_decode;

class PingHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testResponse()
    {
        $pingHandler = new PingHandler();
        $response    = $pingHandler->handle(
            $this->prophesize(ServerRequestInterface::class)->reveal()
        );

        $json = json_decode((string) $response->getBody());

        $this->assertInstanceOf(JsonResponseCore::class, $response);
        $this->assertTrue(isset($json->data->ack));
    }
}
