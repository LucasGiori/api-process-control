<?php


namespace App\Api\Middleware;


use App\Service\AttorneyService;
use App\Service\CompanyService;
use App\Service\ProcessService;
use App\Service\UserService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PostProcessMovementMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PostProcessMovementMiddleware
    {
        $validator       = $container->get(ValidationSymfony::class);
        $deserialization = $container->get(Deserialization::class);
        $processService  = $container->get(ProcessService::class);
        $companyService  = $container->get(CompanyService::class);
        $attorneyService = $container->get(AttorneyService::class);
        $userService     = $container->get(UserService::class);

        return new PostProcessMovementMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            processServiceInterface: $processService,
            companyServiceInterface: $companyService,
            attorneyServiceInterface: $attorneyService,
            userServiceInterface: $userService
        );
    }
}
