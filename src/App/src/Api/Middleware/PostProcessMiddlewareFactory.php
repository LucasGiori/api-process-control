<?php


namespace App\Api\Middleware;


use App\Service\AttorneyService;
use App\Service\CompanyService;
use App\Service\ProcessService;
use App\Service\SituationService;
use App\Service\UserService;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Psr\Container\ContainerInterface;

class PostProcessMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PostProcessMiddleware
    {
        $validator                  = $container->get(ValidationSymfony::class);
        $deserialization            = $container->get(Deserialization::class);
        $companyService             = $container->get(CompanyService::class);
        $userService                = $container->get(UserService::class);
        $processService             = $container->get(ProcessService::class);
        $attorneyService            = $container->get(AttorneyService::class);

        return new PostProcessMiddleware(
            deserialization: $deserialization,
            validation: $validator,
            companyServiceInterface: $companyService,
            userServiceInterface: $userService,
            processServiceInterface: $processService,
            attorneyServiceInterface: $attorneyService
        );
    }
}
