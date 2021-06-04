<?php


namespace App\Dto;

use ReflectionClass;
use ReflectionProperty;

class AbstractBaseDTO
{
    public function __construct(string $class, array|null $data = [])
    {
        if (empty($data)) {
            return;
        }

        $reflectionClass = new ReflectionClass($class);

        foreach ($data as $propertyToSet => $value) {
            if (property_exists(object_or_class: $class, property: $propertyToSet)) {
                $property = $reflectionClass?->getProperty($propertyToSet);
                if ($property instanceof ReflectionProperty) {
                    $property->setAccessible(accessible: true);
                    $property->setValue($this, $value);
                }
            }
        }
    }

}
