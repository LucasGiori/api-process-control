<?php

namespace Infrastructure\Utils\Validation;

use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validation;

class ValidationSymfonyFactory
{
    public function __invoke(ContainerInterface $container): ValidationSymfony
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        return new ValidationSymfony(validator: $validator);
    }
}
