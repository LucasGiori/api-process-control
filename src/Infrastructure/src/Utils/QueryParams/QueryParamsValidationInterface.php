<?php

namespace Infrastructure\Utils\QueryParams;

interface QueryParamsValidationInterface
{
    public function validate(array $queryParams, string $entityName, bool $validateWithSymfony = true): array;
}
