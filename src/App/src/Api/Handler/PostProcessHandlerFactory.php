<?php


namespace App\Api\Handler;


use App\Service\ProcessService;
use Psr\Container\ContainerInterface;

class PostProcessHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostProcessHandler
    {
        $processService = $container->get(ProcessService::class);

        return new PostProcessHandler(processServiceInterface: $processService);
    }
}
