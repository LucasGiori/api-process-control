<?php


namespace App\Api\Handler;


use App\Service\AttorneyService;
use Psr\Container\ContainerInterface;

class GetAttorneyHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetAttorneyHandler
    {
        $attorneyService = $container->get(AttorneyService::class);

        return new GetAttorneyHandler(attorneyServiceInterface: $attorneyService);
    }
}
