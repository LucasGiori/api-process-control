<?php

namespace Infrastructure\Service\Logs\Sentry;

use Http\StatusHttp;
use Infrastructure\Utils\SentryConfig;
use Sentry\Severity;
use Sentry\State\Scope;
use Throwable;
use function Sentry\captureException;
use function Sentry\configureScope;
use function Sentry\init;

class SentryService implements SentryServiceInterface
{
    private array $options;

    public function __construct()
    {
        $this->options = SentryConfig::getOptions();

        if (isset($this->options["development-environment"])) {
            unset($this->options["development-environment"]);
        }
    }

    public function executeSendLogException(Throwable|null $exception): void
    {
        if (empty($exception)) {
            return;
        }

        $code = $exception->getCode();

        /** O código ($code) 0 deve ser verificado, pois exceções que o lançam, são exceções não esperadas/tratadas. */
        if (($code !== 0) && ($code < StatusHttp::INTERNAL_SERVER_ERROR)) {
            return;
        }

        $this->sendLogException($exception);
    }

    public function sendLogException(Throwable $e): void
    {
        $this->options["environment"] = SentryConfig::getEnvironment();
        $this->options["server_name"] = SentryConfig::getServerName();

        init($this->options);
        configureScope(function (Scope $scope): void {
            $scope->setLevel(level: Severity::fatal());
        });
        captureException(exception: $e);
    }
}
