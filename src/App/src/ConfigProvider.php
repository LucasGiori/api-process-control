<?php

namespace App;

use App\Api\Handler\DeleteCompanyHandler;
use App\Api\Handler\DeleteCompanyHandlerFactory;
use App\Api\Handler\GetCityHandler;
use App\Api\Handler\GetCityHandlerFactory;
use App\Api\Handler\GetCompanyHandler;
use App\Api\Handler\GetCompanyHandlerFactory;
use App\Api\Handler\HomePageHandler;
use App\Api\Handler\PingHandler;
use App\Api\Handler\GetStateHandler;
use App\Api\Handler\GetStateHandlerFactory;
use App\Api\Handler\PostCompanyHandler;
use App\Api\Handler\PostCompanyHandlerFactory;
use App\Api\Middleware\GetCityMiddleware;
use App\Api\Middleware\GetCityMiddlewareFactory;
use App\Api\Middleware\GetCompanyMiddleware;
use App\Api\Middleware\GetCompanyMiddlewareFactory;
use App\Api\Middleware\GetStateMiddleware;
use App\Api\Middleware\GetStateMiddlewareFactory;
use App\Api\Middleware\PostCompanyMiddleware;
use App\Api\Middleware\PostCompanyMiddlewareFactory;
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
                HomePageHandler::class => HomePageHandler::class,
                PingHandler::class     => PingHandler::class,
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
                DeleteCompanyHandler::class           => DeleteCompanyHandlerFactory::class
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [];
    }
}
