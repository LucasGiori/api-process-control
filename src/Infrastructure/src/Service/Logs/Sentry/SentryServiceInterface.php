<?php

namespace Infrastructure\Service\Logs\Sentry;

use Throwable;

interface SentryServiceInterface
{
    public function executeSendLogException(Throwable $exception): void;

    public function sendLogException(Throwable $e): void;
}
