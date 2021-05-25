<?php

namespace InfrastructureTest\BaseTest;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    public Client|null $http;

    public function setUp(): void
    {
        $this->http = new Client(config: ["base_uri" => "http://localhost"]);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }
}
