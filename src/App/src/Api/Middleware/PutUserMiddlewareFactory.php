<?php


namespace App\Api\Middleware;


use App\Service\UserService;
use App\Service\UserTypeService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PutUserMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PutUserMiddleware
    {
        $validator                   = $container->get(ValidationSymfony::class);
        $deserialization             = $container->get(Deserialization::class);
        $userTypeService             = $container->get(UserTypeService::class);
        $userService             = $container->get(UserService::class);

        return new PutUserMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            userTypeServiceInterface: $userTypeService,
            userServiceInterface: $userService
        );
    }
}
