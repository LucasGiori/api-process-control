<?php

declare(strict_types=1);

namespace App;

use App\Api\Handler\DeleteCompanyHandler;
use App\Api\Handler\GetCityHandler;
use App\Api\Handler\GetCompanyHandler;
use App\Api\Handler\HomePageHandler;
use App\Api\Handler\PingHandler;
use App\Api\Handler\GetStateHandler;
use App\Api\Handler\PostCompanyHandler;
use App\Api\Middleware\GetCityMiddleware;
use App\Api\Middleware\GetCompanyMiddleware;
use App\Api\Middleware\GetStateMiddleware;
use App\Api\Middleware\PostCompanyMiddleware;
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
        $app->post('/companies', [PostCompanyMiddleware::class, PostCompanyHandler::class], 'company.post');
        $app->delete('/companies/{id:\d+}', [DeleteCompanyHandler::class], 'company.delete');

        return $app;
    }
}