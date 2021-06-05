<?php


namespace App\Api\Handler;


use App\Service\ActionService;
use Psr\Container\ContainerInterface;

class PutActionHandlerFactory
{
    public function __invoke(ContainerInterface $container): PutActionHandler
    {
        $actionService = $container->get(ActionService::class);

        return new PutActionHandler(actionServiceInterface: $actionService);
    }
}
