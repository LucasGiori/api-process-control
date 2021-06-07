<?php


namespace App\Api\Handler;


use App\Service\ProcessMovementService;
use Psr\Container\ContainerInterface;

class PostProcessMovementHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostProcessMovementHandler
    {
        $processMovementService = $container->get(ProcessMovementService::class);

        return new PostProcessMovementHandler(
            processMovementServiceInterface: $processMovementService
        );
    }
}
