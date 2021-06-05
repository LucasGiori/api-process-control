<?php


namespace App\Api\Handler;


use App\Service\ActionTypeService;
use Psr\Container\ContainerInterface;

class GetActionTypeHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetActionTypeHandler
    {
        $actionTypeService = $container->get(ActionTypeService::class);

        return new GetActionTypeHandler(actionTypeServiceInterface: $actionTypeService);
    }
}
