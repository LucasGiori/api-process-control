<?php


namespace App\Api\Handler;


use App\Service\ActionService;
use Psr\Container\ContainerInterface;

class GetActionHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetActionHandler
    {
        $actionService = $container->get(ActionService::class);

        return new GetActionHandler(actionServiceInterface: $actionService);
    }
}
