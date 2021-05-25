<?php

declare(strict_types=1);

namespace AppTest\Api\Handler;

use GuzzleHttp\RequestOptions;
use Http\StatusHttp;
use Infrastructure\HttpRequest\HttpRequest;
use InfrastructureTest\BaseTest\BaseAssert;
use InfrastructureTest\BaseTest\BaseTestCase;

use function json_decode;

class CheckDatabaseConnectionHandlerTest extends BaseTestCase
{
    public function testResponseConnectedDatabase()
    {
        $response = $this->http->request(
            method: HttpRequest::GET,
            uri: "database",
            options: [
                RequestOptions::HTTP_ERRORS => false
            ]
        );
        $json = json_decode($response->getBody()->getContents());

        BaseAssert::assertJsonResponse(response: $response, statusCodeExpected: StatusHttp::OK);
        $this->assertTrue($json->data->connected);
    }
}
