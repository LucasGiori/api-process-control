<?php

namespace Infrastructure\Utils\Validation;

use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\ValidationBodyException;

abstract class ValidationBody
{
    public static function emptyBody(mixed $body): void
    {
        if (empty($body)) {
            throw new ValidationBodyException(
                message: 'O body não pode ser vazio!',
                statusCode: StatusHttp::EXPECTATION_FAILED
            );
        }
    }

}
