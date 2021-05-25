<?php

namespace Infrastructure\Utils\Serializer;

interface DeserializationInterface
{
    public function deserialize(string $body, string $entityName, string $format, string $messageError): mixed;
}
