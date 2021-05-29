<?php

declare(strict_types=1);

namespace App;

use App\Api\Handler\DeleteCompanyHandler;
use App\Api\Handler\GetCityHandler;
use App\Api\Handler\GetCompanyHandler;
use App\Api\Handler\GetCompanyTypeHandler;
use App\Api\Handler\HomePageHandler;
use App\Api\Handler\PingHandler;
use App\Api\Handler\GetStateHandler;
use App\Api\Handler\PostCompanyHandler;
use App\Api\Handler\PutCompanyHandler;
use App\Api\Middleware\GetCityMiddleware;
use App\Api\Middleware\GetCompanyMiddleware;
use App\Api\Middleware\GetCompanyTypeMiddleware;
use App\Api\Middleware\GetStateMiddleware;
use App\Api\Middleware\PostCompanyMiddleware;
use App\Api\Middleware\PutCompanyMiddleware;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/', [HomePageHandler::class], 'home');
        $app->get('/ping', [PingHandler::class], 'ping');//

        $app->get('/states', [GetStateMiddleware::class, GetStateHandler::class], 'states');
        $app->get('/cities', [GetCityMiddleware::class, GetCityHandler::class], 'cities');

        $app->get('/companies', [GetCompanyMiddleware::class, GetCompanyHandler::class], 'company.get');
        $app->put('/companies/{id:\d+}', [PutCompanyMiddleware::class, PutCompanyHandler::class], 'company.put');
        $app->post('/companies', [PostCompanyMiddleware::class, PostCompanyHandler::class], 'company.post');
        $app->delete('/companies/{id:\d+}', [DeleteCompanyHandler::class], 'company.delete');

        $app->get('/companies/types', [GetCompanyTypeMiddleware::class,GetCompanyTypeHandler::class], 'company.types.get');

        return $app;
    }
}
