<?php

declare(strict_types=1);

namespace AppTest\Service\Database;

use App\Service\Database\CheckDatabaseConnectionService;
use App\Service\Database\CheckDatabaseConnectionServiceFactory;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;

class CheckDatabaseConnectionServiceFactoryTest extends TestCase
{
    use ProphecyTrait;

    public function testFactory()
    {
        $factory = new CheckDatabaseConnectionServiceFactory();

        $this->assertInstanceOf(CheckDatabaseConnectionServiceFactory::class, $factory);

        $container = $this->prophesize(ContainerInterface::class);

        $container->has(EntityManager::class)->willReturn(true);
        $container
            ->get(EntityManager::class)
            ->willReturn($this->prophesize(EntityManager::class));

        $factory = new CheckDatabaseConnectionServiceFactory();

        $checkDatabaseConnection = $factory($container->reveal());

        $this->assertInstanceOf(CheckDatabaseConnectionService::class, $checkDatabaseConnection);
    }
}
