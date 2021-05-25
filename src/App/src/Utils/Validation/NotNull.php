<?php


namespace App\Utils\Validation;


use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\ValidationException;

class NotNull
{
    public static function validate(
        $value,
        int $statusCode = StatusHttp::EXPECTATION_FAILED,
        string $message = "O valor está nulo, verifique e tente novamente!"
    ): void
    {
        if(is_null($value)) {
            throw new ValidationException(
                message: $message,
                statusCode: $statusCode
            );
        }
    }
}
