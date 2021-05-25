<?php

namespace Infrastructure\Utils\CustomResultMapping;

use Exception;
use Http\StatusHttp;
use ReflectionClass;
use Doctrine\ORM\Query\ResultSetMapping;
use Infrastructure\Domain\Exceptions\CustomResultMappingException;

class CustomResult
{
    public static function addResultEntity(string $entityClass, string $alias = "tb"): ResultSetMapping
    {
        try {
            $resultSetMapping = new ResultSetMapping();

            $reflectionClass = new ReflectionClass(objectOrClass: $entityClass);

            $resultSetMapping->addEntityResult(class: $entityClass, alias: $alias);

            foreach ($reflectionClass->getProperties() as $property) {
                $resultSetMapping->addFieldResult(
                    alias: $alias,
                    columnName: $property->getName(),
                    fieldName: $property->getName()
                );
            }

            return $resultSetMapping;
        } catch (Exception $e) {
            throw new CustomResultMappingException(
                message: StatusHttp::INTERNAL_SERVER_ERROR,
                statusCode: sprintf("Ocorreu um erro ao converter o retorno para classe %s!", $entityClass),
                internalMessageError: $e->getMessage()
            );
        }
    }
}
