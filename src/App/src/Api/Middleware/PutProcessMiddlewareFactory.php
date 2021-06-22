<?php


namespace App\Api\Middleware;


use App\Service\ActionService;
use App\Service\AttorneyService;
use App\Service\CompanyService;
use App\Service\ProcessService;
use App\Service\UserService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PutProcessMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PutProcessMiddleware
    {
        $validator                  = $container->get(ValidationSymfony::class);
        $deserialization            = $container->get(Deserialization::class);
        $userService                = $container->get(UserService::class);
        $processService             = $container->get(ProcessService::class);
        $actionService              = $container->get(ActionService::class);

        return new PutProcessMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            userServiceInterface: $userService,
            processServiceInterface: $processService,
            actionServiceInterface: $actionService
        );
    }
}
