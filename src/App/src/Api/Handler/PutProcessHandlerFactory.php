<?php


namespace App\Api\Handler;


use App\Service\ProcessService;
use Psr\Container\ContainerInterface;

class PutProcessHandlerFactory
{
    public function __invoke(ContainerInterface $container): PutProcessHandler
    {
        $processService = $container->get(ProcessService::class);

        return new PutProcessHandler(processServiceInterface: $processService);
    }
}
