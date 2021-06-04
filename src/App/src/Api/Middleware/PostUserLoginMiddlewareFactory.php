<?php


namespace App\Api\Middleware;


use App\Service\UserService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PostUserLoginMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PostUserLoginMiddleware
    {
        $validator                   = $container->get(ValidationSymfony::class);
        $deserialization             = $container->get(Deserialization::class);
        $userService                 = $container->get(UserService::class);

        return new PostUserLoginMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            userServiceInterface: $userService
        );
    }
}
