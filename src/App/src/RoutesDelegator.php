<?php

declare(strict_types=1);

namespace App;

use App\Api\Handler\DeleteCompanyHandler;
use App\Api\Handler\GetActionHandler;
use App\Api\Handler\GetActionTypeHandler;
use App\Api\Handler\GetAttorneyHandler;
use App\Api\Handler\GetCityHandler;
use App\Api\Handler\GetCompanyHandler;
use App\Api\Handler\GetCompanyTypeHandler;
use App\Api\Handler\GetProcessHandler;
use App\Api\Handler\GetUserHandler;
use App\Api\Handler\GetUserTypeHandler;
use App\Api\Handler\HomePageHandler;
use App\Api\Handler\PingHandler;
use App\Api\Handler\GetStateHandler;
use App\Api\Handler\PostActionHandler;
use App\Api\Handler\PostAttorneyHandler;
use App\Api\Handler\PostCompanyHandler;
use App\Api\Handler\PostProcessHandler;
use App\Api\Handler\PostUserHandler;
use App\Api\Handler\PostUserLoginHandler;
use App\Api\Handler\PutActionHandler;
use App\Api\Handler\PutAttorneyHandler;
use App\Api\Handler\PutCompanyHandler;
use App\Api\Handler\PutUserHandler;
use App\Api\Middleware\AuthorizationMiddleware;
use App\Api\Middleware\GetActionMiddleware;
use App\Api\Middleware\GetActionTypeMiddleware;
use App\Api\Middleware\GetAttorneyMiddleware;
use App\Api\Middleware\GetCityMiddleware;
use App\Api\Middleware\GetCompanyMiddleware;
use App\Api\Middleware\GetCompanyTypeMiddleware;
use App\Api\Middleware\GetProcessMiddleware;
use App\Api\Middleware\GetStateMiddleware;
use App\Api\Middleware\GetUserMiddleware;
use App\Api\Middleware\GetUserTypeMiddleware;
use App\Api\Middleware\PostActionMiddleware;
use App\Api\Middleware\PostAttorneyMiddleware;
use App\Api\Middleware\PostCompanyMiddleware;
use App\Api\Middleware\PostProcessMiddleware;
use App\Api\Middleware\PostUserLoginMiddleware;
use App\Api\Middleware\PostUserMiddleware;
use App\Api\Middleware\PostUserMiddlewareFactory;
use App\Api\Middleware\PutActionMiddleware;
use App\Api\Middleware\PutAttorneyMiddleware;
use App\Api\Middleware\PutCompanyMiddleware;
use App\Api\Middleware\PutUserMiddleware;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/', [HomePageHandler::class], 'home');
        $app->get('/ping', [PingHandler::class], 'ping');

        $app->post('/login', [PostUserLoginMiddleware::class, PostUserLoginHandler::class], 'login.get');

        $app->get('/users/types', [AuthorizationMiddleware::class, GetUserTypeMiddleware::class, GetUserTypeHandler::class], 'users.types.get');


        $app->get('/users', [AuthorizationMiddleware::class, GetUserMiddleware::class, GetUserHandler::class], 'users.get');
        $app->put('/users/{id:\d+}', [AuthorizationMiddleware::class, PutUserMiddleware::class, PutUserHandler::class], 'users.put');
        $app->post('/users', [AuthorizationMiddleware::class, PostUserMiddleware::class, PostUserHandler::class], 'users.post');

        $app->get('/states', [AuthorizationMiddleware::class, GetStateMiddleware::class, GetStateHandler::class], 'states');
        $app->get('/cities', [AuthorizationMiddleware::class, GetCityMiddleware::class, GetCityHandler::class], 'cities');

        $app->get('/companies', [AuthorizationMiddleware::class, GetCompanyMiddleware::class, GetCompanyHandler::class], 'company.get');
        $app->put('/companies/{id:\d+}', [AuthorizationMiddleware::class, PutCompanyMiddleware::class, PutCompanyHandler::class], 'company.put');
        $app->post('/companies', [AuthorizationMiddleware::class, PostCompanyMiddleware::class, PostCompanyHandler::class], 'company.post');
        $app->delete('/companies/{id:\d+}', [AuthorizationMiddleware::class, DeleteCompanyHandler::class], 'company.delete');

        $app->get('/companies/types', [AuthorizationMiddleware::class, GetCompanyTypeMiddleware::class,GetCompanyTypeHandler::class], 'company.types.get');

        $app->get('/attorney', [AuthorizationMiddleware::class, GetAttorneyMiddleware::class,GetAttorneyHandler::class], 'attorney.get');
        $app->put('/attorney/{id:\d+}', [AuthorizationMiddleware::class, PutAttorneyMiddleware::class,PutAttorneyHandler::class], 'attorney.put');
        $app->post('/attorney', [AuthorizationMiddleware::class, PostAttorneyMiddleware::class,PostAttorneyHandler::class], 'attorney.post');


        $app->get('/actions', [AuthorizationMiddleware::class,GetActionMiddleware::class,GetActionHandler::class], 'actions.get');
        $app->put('/actions/{id:\d+}', [AuthorizationMiddleware::class, PutActionMiddleware::class,PutActionHandler::class], 'actions.put');
        $app->post('/actions', [AuthorizationMiddleware::class,PostActionMiddleware::class,PostActionHandler::class], 'actions.post');

        $app->get('/actions/types', [AuthorizationMiddleware::class,GetActionTypeMiddleware::class,GetActionTypeHandler::class], 'actions.types.get');

        $app->get('/process', [AuthorizationMiddleware::class,GetProcessMiddleware::class,GetProcessHandler::class], 'process.get');
        $app->post('/process', [AuthorizationMiddleware::class,PostProcessMiddleware::class,PostProcessHandler::class], 'process.post');


        return $app;
    }
}
