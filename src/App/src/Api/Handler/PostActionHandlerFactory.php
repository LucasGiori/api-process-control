<?php


namespace App\Api\Handler;


use App\Service\ActionService;
use Psr\Container\ContainerInterface;

class PostActionHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostActionHandler
    {
        $actionService = $container->get(ActionService::class);

        return new PostActionHandler(actionServiceInterface: $actionService);
    }
}
