<?php


namespace App\Api\Handler;


use App\Service\ProcessMovementService;
use Psr\Container\ContainerInterface;

class GetProcessMovementHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetProcessMovementHandler
    {
        $processMovementService = $container->get(ProcessMovementService::class);

        return new GetProcessMovementHandler(processMovementServiceInterface: $processMovementService);
    }
}
