<?php


namespace App\Api\Middleware;


use App\Service\ActionTypeService;
use App\Service\SituationService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PostActionMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PostActionMiddleware
    {
        $validator                   = $container->get(ValidationSymfony::class);
        $deserialization             = $container->get(Deserialization::class);
        $actionTypeService           = $container->get(ActionTypeService::class);
        $situationService            = $container->get(SituationService::class);

        return new PostActionMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            actionTypeServiceInterface: $actionTypeService,
            situationServiceInterface: $situationService
        );
    }
}
