<?php

namespace Infrastructure\Utils\Validation;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use function in_array;
use function sprintf;

class ValidationSymfony implements ValidationSymfonyInterface
{
    public function __construct(
        private ValidatorInterface $validator
    ){}

    public function validateEntitySpecificFields(array $fieldsToValidate, object $entityOrObject): string
    {
        $messageError = "";
        $errors = $this->validator->validate($entityOrObject);

        foreach ($errors as $error) {
            if (in_array($error->getPropertyPath(), $fieldsToValidate)) {
                $messageError .= sprintf("%s; ", $error->getMessage());
            }
        }

        return $messageError;
    }

    public function validateAllFieldsEntity(object $entityOrObject): string
    {
        $messageError = "";
        $errors = $this->validator->validate($entityOrObject);

        foreach ($errors as $error) {
            $messageError .= sprintf("%s; ", $error->getMessage());
        }

        return $messageError;
    }
}
