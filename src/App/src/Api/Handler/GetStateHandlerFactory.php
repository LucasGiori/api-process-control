<?php


namespace App\Api\Handler;


use App\Service\StateService;
use Psr\Container\ContainerInterface;

class GetStateHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetStateHandler
    {
        $stateService = $container->get(StateService::class);

        return new GetStateHandler(stateServiceInterface: $stateService);
    }
}
