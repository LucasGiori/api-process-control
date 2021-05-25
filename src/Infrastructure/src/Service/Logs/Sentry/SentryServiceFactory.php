<?php

namespace Infrastructure\Service\Logs\Sentry;

use Psr\Container\ContainerInterface;

class SentryServiceFactory
{
    public function __invoke(ContainerInterface $container): SentryService
    {
        return new SentryService();
    }
}
