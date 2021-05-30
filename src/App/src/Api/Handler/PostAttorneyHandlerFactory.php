<?php


namespace App\Api\Handler;


use App\Service\AttorneyService;
use Psr\Container\ContainerInterface;

class PostAttorneyHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostAttorneyHandler
    {
        $attorneyService = $container->get(AttorneyService::class);

        return new PostAttorneyHandler(attorneyServiceInterface: $attorneyService);
    }
}
