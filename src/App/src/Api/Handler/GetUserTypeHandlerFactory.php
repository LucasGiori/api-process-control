<?php


namespace App\Api\Handler;


use App\Service\UserTypeService;
use Psr\Container\ContainerInterface;

class GetUserTypeHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetUserTypeHandler
    {
        $userTypeService = $container->get(UserTypeService::class);

        return new GetUserTypeHandler(userTypeServiceInterface: $userTypeService);
    }
}
