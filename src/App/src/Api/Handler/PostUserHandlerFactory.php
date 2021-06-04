<?php


namespace App\Api\Handler;


use App\Service\UserService;
use Psr\Container\ContainerInterface;

class PostUserHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostUserHandler
    {
        $userService = $container->get(UserService::class);

        return new PostUserHandler(userServiceInterface: $userService);
    }
}
