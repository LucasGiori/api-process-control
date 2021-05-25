<?php


namespace Infrastructure\Utils\Serializer;


use Psr\Container\ContainerInterface;

class DeserializationFactory
{
    public function __invoke(ContainerInterface $container): Deserialization
    {
        $jms = $container->get("serializer");

        return new Deserialization(jms: $jms);
    }
}
