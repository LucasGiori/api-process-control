<?php

namespace Infrastructure\Service\Logs;

use Infrastructure\Service\Logs\Sentry\SentryService;
use Psr\Container\ContainerInterface;

class LogsServiceFactory
{
    public function __invoke(ContainerInterface $container): LogsService
    {
        $sentry = $container->get(SentryService::class);

        return new LogsService(sentryService: $sentry);
    }
}
