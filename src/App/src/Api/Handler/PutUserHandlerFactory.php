<?php


namespace App\Api\Handler;


use App\Service\UserService;
use Psr\Container\ContainerInterface;

class PutUserHandlerFactory
{
    public function __invoke(ContainerInterface $container): PutUserHandler
    {
        $userService = $container->get(UserService::class);

        return new PutUserHandler(userServiceInterface: $userService);
    }
}
