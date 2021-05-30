<?php


namespace App\Api\Handler;


use App\Service\AttorneyService;
use Psr\Container\ContainerInterface;

class PutAttorneyHandlerFactory
{
    public function __invoke(ContainerInterface $container): PutAttorneyHandler
    {
        $attorneyService = $container->get(AttorneyService::class);

        return new PutAttorneyHandler(attorneyServiceInterface: $attorneyService);
    }
}
