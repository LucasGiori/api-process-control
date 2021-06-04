<?php


namespace App\Api\Middleware;


use App\Service\AuthenticationTokenService;
use App\Service\UserService;
use Psr\Container\ContainerInterface;

class AuthorizationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): AuthorizationMiddleware
    {
        $authenticationService = $container->get(AuthenticationTokenService::class);
        $userService           = $container->get(UserService::class);

        return new AuthorizationMiddleware(
            authenticationTokenServiceInterface: $authenticationService,
            userServiceInterface: $userService
        );
    }
}
