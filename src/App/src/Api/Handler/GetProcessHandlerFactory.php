<?php


namespace App\Api\Handler;


use App\Service\ProcessService;
use Psr\Container\ContainerInterface;

class GetProcessHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetProcessHandler
    {
        $processService = $container->get(ProcessService::class);

        return new GetProcessHandler(processServiceInterface: $processService);
    }
}
