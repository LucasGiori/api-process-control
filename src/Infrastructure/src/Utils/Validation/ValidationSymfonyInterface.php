<?php

namespace Infrastructure\Utils\Validation;

interface ValidationSymfonyInterface
{
    public function validateEntitySpecificFields(array $fieldsToValidate, object $entityOrObject): string;

    public function validateAllFieldsEntity(object $entityOrObject): string;
}
