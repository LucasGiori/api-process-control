<?php


namespace App\Api\Middleware;


use App\Service\UserService;
use App\Service\UserTypeService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PostUserMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PostUserMiddleware
    {
        $validator                   = $container->get(ValidationSymfony::class);
        $deserialization             = $container->get(Deserialization::class);
        $userTypeService             = $container->get(UserTypeService::class);
        $userService             = $container->get(UserService::class);

        return new PostUserMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            userTypeServiceInterface: $userTypeService,
            userServiceInterface: $userService
        );
    }
}
