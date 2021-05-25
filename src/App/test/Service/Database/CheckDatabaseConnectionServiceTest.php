<?php

declare(strict_types=1);

namespace AppTest\Service\Database;

use App\Service\Database\CheckDatabaseConnectionService;
use App\Service\Port\Exception\CheckConnectionDatabaseException;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class CheckDatabaseConnectionServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testResponseErrorCheckConnectDatabase()
    {
        $connection = $this->createMock(Connection::class);
        $connection->expects($this->any())
            ->method('isConnected')
            ->willReturn(false);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())
            ->method('getConnection')
            ->willReturn($connection);

        $checkDatabaseConnectionService = new CheckDatabaseConnectionService($entityManager);

        $this->expectException(CheckConnectionDatabaseException::class);
        $checkDatabaseConnectionService->checkConnection();
    }

    public function testResponseSuccessCheckConnectDatabase()
    {
        $connection = $this->createMock(Connection::class);
        $connection->expects($this->any())
            ->method('isConnected')
            ->willReturn(true);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())
            ->method('getConnection')
            ->willReturn($connection);

        $checkDatabaseConnectionService = new CheckDatabaseConnectionService($entityManager);

        try {
            $checkDatabaseConnectionService->checkConnection();
        } catch (CheckConnectionDatabaseException $notExpected) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testResponseErrorIsConnectDatabase()
    {
        $connection = $this->createMock(Connection::class);
        $connection->expects($this->any())
            ->method('isConnected')
            ->will($this->throwException(new Exception()));

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())
            ->method('getConnection')
            ->willReturn($connection);

        $checkDatabaseConnectionService = new CheckDatabaseConnectionService($entityManager);

        $this->expectException(CheckConnectionDatabaseException::class);
        $checkDatabaseConnectionService->isConnected();
    }

    public function testResponseSuccessIsConnectDatabase()
    {
        $connection = $this->createMock(Connection::class);
        $connection->expects($this->any())
            ->method('isConnected')
            ->willReturn(true);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())
            ->method('getConnection')
            ->willReturn($connection);

        $checkDatabaseConnectionService = new CheckDatabaseConnectionService($entityManager);

        try {
            $connected = $checkDatabaseConnectionService->isConnected();
        } catch (CheckConnectionDatabaseException $notExpected) {
            $this->fail();
        }

        $this->assertTrue($connected);
    }

    public function testResponseNotConnectDatabase()
    {
        $connection = $this->createMock(Connection::class);
        $connection->expects($this->any())
            ->method('isConnected')
            ->willReturn(false);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())
            ->method('getConnection')
            ->willReturn($connection);

        $checkDatabaseConnectionService = new CheckDatabaseConnectionService($entityManager);

        try {
            $connected = $checkDatabaseConnectionService->isConnected();
        } catch (CheckConnectionDatabaseException $notExpected) {
            $this->fail();
        }

        $this->assertFalse($connected);
    }
}
