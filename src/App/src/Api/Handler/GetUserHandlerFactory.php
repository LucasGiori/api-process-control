<?php


namespace App\Api\Handler;


use App\Service\UserService;
use Psr\Container\ContainerInterface;

class GetUserHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetUserHandler
    {
        $userService = $container->get(UserService::class);

        return new GetUserHandler(userServiceInterface: $userService);
    }

}
