<?php

namespace App;

use App\Api\Handler\DeleteCompanyHandler;
use App\Api\Handler\DeleteCompanyHandlerFactory;
use App\Api\Handler\GetActionHandler;
use App\Api\Handler\GetActionHandlerFactory;
use App\Api\Handler\GetActionTypeHandler;
use App\Api\Handler\GetActionTypeHandlerFactory;
use App\Api\Handler\GetAttorneyHandler;
use App\Api\Handler\GetAttorneyHandlerFactory;
use App\Api\Handler\GetCityHandler;
use App\Api\Handler\GetCityHandlerFactory;
use App\Api\Handler\GetCompanyHandler;
use App\Api\Handler\GetCompanyHandlerFactory;
use App\Api\Handler\GetCompanyTypeHandler;
use App\Api\Handler\GetCompanyTypeHandlerFactory;
use App\Api\Handler\GetUserHandler;
use App\Api\Handler\GetUserHandlerFactory;
use App\Api\Handler\GetUserTypeHandler;
use App\Api\Handler\GetUserTypeHandlerFactory;
use App\Api\Handler\HomePageHandler;
use App\Api\Handler\PingHandler;
use App\Api\Handler\GetStateHandler;
use App\Api\Handler\GetStateHandlerFactory;
use App\Api\Handler\PostActionHandler;
use App\Api\Handler\PostActionHandlerFactory;
use App\Api\Handler\PostAttorneyHandler;
use App\Api\Handler\PostAttorneyHandlerFactory;
use App\Api\Handler\PostCompanyHandler;
use App\Api\Handler\PostCompanyHandlerFactory;
use App\Api\Handler\PostUserHandler;
use App\Api\Handler\PostUserHandlerFactory;
use App\Api\Handler\PostUserLoginHandler;
use App\Api\Handler\PostUserLoginHandlerFactory;
use App\Api\Handler\PutActionHandler;
use App\Api\Handler\PutActionHandlerFactory;
use App\Api\Handler\PutAttorneyHandler;
use App\Api\Handler\PutAttorneyHandlerFactory;
use App\Api\Handler\PutCompanyHandler;
use App\Api\Handler\PutCompanyHandlerFactory;
use App\Api\Handler\PutUserHandler;
use App\Api\Handler\PutUserHandlerFactory;
use App\Api\Middleware\AuthorizationMiddleware;
use App\Api\Middleware\AuthorizationMiddlewareFactory;
use App\Api\Middleware\GetActionMiddleware;
use App\Api\Middleware\GetActionMiddlewareFactory;
use App\Api\Middleware\GetActionTypeMiddleware;
use App\Api\Middleware\GetActionTypeMiddlewareFactory;
use App\Api\Middleware\GetAttorneyMiddleware;
use App\Api\Middleware\GetAttorneyMiddlewareFactory;
use App\Api\Middleware\GetCityMiddleware;
use App\Api\Middleware\GetCityMiddlewareFactory;
use App\Api\Middleware\GetCompanyMiddleware;
use App\Api\Middleware\GetCompanyMiddlewareFactory;
use App\Api\Middleware\GetCompanyTypeMiddleware;
use App\Api\Middleware\GetCompanyTypeMiddlewareFactory;
use App\Api\Middleware\GetStateMiddleware;
use App\Api\Middleware\GetStateMiddlewareFactory;
use App\Api\Middleware\GetUserMiddleware;
use App\Api\Middleware\GetUserMiddlewareFactory;
use App\Api\Middleware\GetUserTypeMiddleware;
use App\Api\Middleware\GetUserTypeMiddlewareFactory;
use App\Api\Middleware\PostActionMiddleware;
use App\Api\Middleware\PostActionMiddlewareFactory;
use App\Api\Middleware\PostAttorneyMiddleware;
use App\Api\Middleware\PostAttorneyMiddlewareFactory;
use App\Api\Middleware\PostCompanyMiddleware;
use App\Api\Middleware\PostCompanyMiddlewareFactory;
use App\Api\Middleware\PostUserLoginMiddleware;
use App\Api\Middleware\PostUserLoginMiddlewareFactory;
use App\Api\Middleware\PostUserMiddleware;
use App\Api\Middleware\PostUserMiddlewareFactory;
use App\Api\Middleware\PutActionMiddleware;
use App\Api\Middleware\PutActionMiddlewareFactory;
use App\Api\Middleware\PutAttorneyMiddleware;
use App\Api\Middleware\PutAttorneyMiddlewareFactory;
use App\Api\Middleware\PutCompanyMiddleware;
use App\Api\Middleware\PutCompanyMiddlewareFactory;
use App\Api\Middleware\PutUserMiddleware;
use App\Api\Middleware\PutUserMiddlewareFactory;
use App\Service\ActionService;
use App\Service\ActionServiceFactory;
use App\Service\ActionTypeService;
use App\Service\ActionTypeServiceFactory;
use App\Service\AttorneyService;
use App\Service\AttorneyServiceFactory;
use App\Service\AuthenticationTokenService;
use App\Service\AuthenticationTokenServiceFactory;
use App\Service\CityService;
use App\Service\CityServiceFactory;
use App\Service\CompanyService;
use App\Service\CompanyServiceFactory;
use App\Service\CompanyTypeService;
use App\Service\CompanyTypeServiceFactory;
use App\Service\SituationService;
use App\Service\SituationServiceFactory;
use App\Service\StateService;
use App\Service\StateServiceFactory;
use App\Service\UserService;
use App\Service\UserServiceFactory;
use App\Service\UserTypeService;
use App\Service\UserTypeServiceFactory;
use ContainerInteropDoctrine\EntityManagerFactory;
use Doctrine\ORM\EntityManager;
use Infrastructure\Container\JMSFactory;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Infrastructure\Utils\Validation\ValidationSymfonyFactory;
use Mezzio\Application;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [RoutesDelegator::class],
            ],
            'invokables' => [],
            'factories'  => [
                "serializer"                          => JMSFactory::class,
                EntityManager::class                  => EntityManagerFactory::class,
                HomePageHandler::class                => HomePageHandler::class,
                PingHandler::class                    => PingHandler::class,
                ValidationSymfony::class              => ValidationSymfonyFactory::class,
                CityService::class                    => CityServiceFactory::class,
                CompanyService::class                 => CompanyServiceFactory::class,
                CompanyTypeService::class             => CompanyTypeServiceFactory::class,
                SituationService::class               => SituationServiceFactory::class,
                StateService::class                   => StateServiceFactory::class,
                GetStateMiddleware::class             => GetStateMiddlewareFactory::class,
                GetStateHandler::class                => GetStateHandlerFactory::class,
                GetCityMiddleware::class              => GetCityMiddlewareFactory::class,
                GetCityHandler::class                 => GetCityHandlerFactory::class,
                GetCompanyMiddleware::class           => GetCompanyMiddlewareFactory::class,
                GetCompanyHandler::class              => GetCompanyHandlerFactory::class,
                PostCompanyMiddleware::class          => PostCompanyMiddlewareFactory::class,
                PostCompanyHandler::class             => PostCompanyHandlerFactory::class,
                PutCompanyMiddleware::class           => PutCompanyMiddlewareFactory::class,
                PutCompanyHandler::class              => PutCompanyHandlerFactory::class,
                DeleteCompanyHandler::class           => DeleteCompanyHandlerFactory::class,
                GetCompanyTypeMiddleware::class       => GetCompanyTypeMiddlewareFactory::class,
                GetCompanyTypeHandler::class          => GetCompanyTypeHandlerFactory::class,
                PostAttorneyMiddleware::class         => PostAttorneyMiddlewareFactory::class,
                PostAttorneyHandler::class            => PostAttorneyHandlerFactory::class,
                AttorneyService::class                => AttorneyServiceFactory::class,
                GetAttorneyMiddleware::class          => GetAttorneyMiddlewareFactory::class,
                GetAttorneyHandler::class             => GetAttorneyHandlerFactory::class,
                PutAttorneyMiddleware::class          => PutAttorneyMiddlewareFactory::class,
                PutAttorneyHandler::class             => PutAttorneyHandlerFactory::class,
                UserService::class                    => UserServiceFactory::class,
                UserTypeService::class                => UserTypeServiceFactory::class,
                PostUserMiddleware::class             => PostUserMiddlewareFactory::class,
                PostUserHandler::class                => PostUserHandlerFactory::class,
                GetUserMiddleware::class              => GetUserMiddlewareFactory::class,
                GetUserHandler::class                 => GetUserHandlerFactory::class,
                PostUserLoginMiddleware::class        => PostUserLoginMiddlewareFactory::class,
                PostUserLoginHandler::class           => PostUserLoginHandlerFactory::class,
                AuthenticationTokenService::class     => AuthenticationTokenServiceFactory::class,
                AuthorizationMiddleware::class        => AuthorizationMiddlewareFactory::class,
                PutUserMiddleware::class              => PutUserMiddlewareFactory::class,
                PutUserHandler::class                 => PutUserHandlerFactory::class,
                GetUserTypeMiddleware::class          => GetUserTypeMiddlewareFactory::class,
                GetUserTypeHandler::class             => GetUserTypeHandlerFactory::class,
                ActionService::class                  => ActionServiceFactory::class,
                ActionTypeService::class              => ActionTypeServiceFactory::class,
                GetActionMiddleware::class            => GetActionMiddlewareFactory::class,
                GetActionTypeMiddleware::class        => GetActionTypeMiddlewareFactory::class,
                GetActionHandler::class               => GetActionHandlerFactory::class,
                GetActionTypeHandler::class           => GetActionTypeHandlerFactory::class,
                PostActionMiddleware::class           => PostActionMiddlewareFactory::class,
                PostActionHandler::class              => PostActionHandlerFactory::class,
                PutActionMiddleware::class            => PutActionMiddlewareFactory::class,
                PutActionHandler::class               => PutActionHandlerFactory::class
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [];
    }
}
