<?php


namespace App\Api\Middleware;


use App\Service\ActionService;
use App\Service\ActionTypeService;
use App\Service\SituationService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PutActionMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PutActionMiddleware
    {
        $validator                   = $container->get(ValidationSymfony::class);
        $deserialization             = $container->get(Deserialization::class);
        $actionTypeService           = $container->get(ActionTypeService::class);
        $situationService            = $container->get(SituationService::class);
        $actionService           = $container->get(ActionService::class);

        return new PutActionMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            actionTypeServiceInterface: $actionTypeService,
            situationServiceInterface: $situationService,
            actionServiceInterface: $actionService
        );
    }
}
