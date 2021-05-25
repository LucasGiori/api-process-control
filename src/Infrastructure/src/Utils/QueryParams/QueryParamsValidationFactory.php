<?php

namespace Infrastructure\Utils\QueryParams;

use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validation;

class QueryParamsValidationFactory
{
    public function __invoke(ContainerInterface $container): QueryParamsValidation
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $jms       = $container->get("serializer");

        return new QueryParamsValidation($validator, $jms);
    }
}
