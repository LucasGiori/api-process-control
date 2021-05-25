<?php

namespace Infrastructure\Utils;

use Exception;
use Http\StatusHttp;
use ReflectionObject;

use function get_class;

class CompareObjectsReplace
{
    public static function compare(object $objectBase, object $objectRequest): object
    {
        try {
            if (get_class($objectBase) == get_class($objectRequest)) {
                $objectBaseProperties   = (new ReflectionObject($objectBase))->getProperties();
                $objectRequestReflected = new ReflectionObject($objectRequest);

                foreach ($objectBaseProperties as $objectBaseProperty) {
                    $objectRequestProperty = $objectRequestReflected->getProperty($objectBaseProperty->getName());

                    $objectBaseProperty->setAccessible(true);
                    $objectRequestProperty->setAccessible(true);

                    if (
                        $objectRequestProperty->isInitialized($objectRequest) &&
                        ($objectBaseProperty->getValue($objectBase)) !=
                        ($newValue = $objectRequestProperty->getValue($objectRequest))
                    ) {
                        $objectBaseProperty->setValue($objectBase, $newValue);
                    }
                }
            }

            return $objectBase;
        } catch (Exception $e) {
            throw new Exception(
                $e->getMessage(),
                StatusHttp::INTERNAL_SERVER_ERROR
            );
        }
    }
}
