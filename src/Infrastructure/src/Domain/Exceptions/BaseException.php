<?php


namespace Infrastructure\Domain\Exceptions;

use ApiCore\Exception\Config;
use ApiCore\Exception\ExceptionCore;

class BaseException extends ExceptionCore
{
    public function __construct(
        string $message,
        int $statusCode = 500,
        string $internalMessageError = "",
        string $traceError = "",
        array $arrayError = [],
        bool $repeatMessageError = false
    )
    {
        $configExceptionCore = new Config();
        $configExceptionCore->setStatusCode($statusCode);
        $configExceptionCore->setMessageError($message);
        $configExceptionCore->setInternalMessageError($internalMessageError);
        $configExceptionCore->setTraceError($traceError);
        $configExceptionCore->setArrayError($arrayError);
        $configExceptionCore->setInternalCode($repeatMessageError);

        parent::__construct($configExceptionCore);
    }
}
