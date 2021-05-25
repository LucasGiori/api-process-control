<?php

namespace Infrastructure\Utils\Serializer;

use Exception;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\DeserializeException;
use JMS\Serializer\Serializer;
use TypeError;

class Deserialization implements DeserializationInterface
{
    public function __construct(
        private Serializer $jms
    ) {}

    public function deserialize(
        string $body,
        string $entityName,
        string $format = "json",
        string $messageError = "Erro ao tentar realizar a deserialização do objeto!"
    ): mixed
    {
        try {
            return $this->jms->deserialize(
                data: $body,
                type: $entityName,
                format: $format
            );
        } catch (TypeError | Exception $e) {
            throw new DeserializeException(
                message: $messageError,
                statusCode: StatusHttp::EXPECTATION_FAILED,
                internalMessageError: $e->getMessage()
            );
        }
    }
}
