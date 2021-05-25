<?php

namespace Infrastructure\Utils\Validation;

use Exception;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\ValidationException;
use TypeError;

abstract class ValidationArrayKeys
{
    public static function validJsonAndReturnArrayKeys(string $json): array
    {
        try {
            $fields = array_keys(json_decode($json, true));

            return $fields;
        } catch (TypeError | Exception $e) {
            throw new ValidationException(
                message: "Ocorreu um erro verifique a estrutura e tente novamente!",
                statusCode: StatusHttp::EXPECTATION_FAILED,
                internalMessageError: $e->getMessage()
            );
        }
    }

    public static function validArrayAndReturnArrayKeys(array $array): array
    {
        try {
            $fields = array_keys($array);

            return $fields;
        } catch (TypeError | Exception $e) {
            throw new ValidationException(
                message: "Ocorreu um erro verifique a estrutura e tente novamente!",
                statusCode: StatusHttp::EXPECTATION_FAILED,
                internalMessageError: $e->getMessage()
            );
        }
    }
}
