<?php


namespace App\Api\Handler;


use App\Service\CityService;
use Psr\Container\ContainerInterface;

class GetCityHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetCityHandler
    {
        $cityService = $container->get(CityService::class);

        return new GetCityHandler(cityServiceInterface: $cityService);
    }
}
