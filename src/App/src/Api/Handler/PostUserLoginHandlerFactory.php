<?php


namespace App\Api\Handler;


use App\Service\AuthenticationTokenService;
use Psr\Container\ContainerInterface;

class PostUserLoginHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostUserLoginHandler
    {
        $authenticationTokenService = $container->get(AuthenticationTokenService::class);

        return new PostUserLoginHandler(authenticationTokenServiceInterface: $authenticationTokenService);
    }
}
