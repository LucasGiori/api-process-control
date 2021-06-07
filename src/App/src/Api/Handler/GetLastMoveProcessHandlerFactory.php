<?php


namespace App\Api\Handler;


use App\Service\ProcessMovementService;
use Psr\Container\ContainerInterface;

class GetLastMoveProcessHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetLastMoveProcessHandler
    {
        $processMovementService = $container->get(ProcessMovementService::class);

        return new GetLastMoveProcessHandler(processMovementServiceInterface: $processMovementService);
    }
}
