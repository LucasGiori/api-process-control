<?php

namespace Infrastructure\Utils\QueryParams;

use Exception;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\ValidationException;
use Infrastructure\Utils\QueryParams\Exceptions\QueryParamsDeserializationException;
use Infrastructure\Utils\QueryParams\Exceptions\QueryParamsValidationException;
use Infrastructure\Utils\Validation\ValidationArrayKeys;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use TypeError;
use function array_keys;
use function in_array;
use function json_encode;
use function property_exists;
use function sprintf;

class QueryParamsValidation implements QueryParamsValidationInterface
{
    private ValidatorInterface $validator;

    private SerializerInterface $serializer;

    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator  = $validator;
        $this->serializer = $serializer;
    }

    public function validate(array $queryParams, string $entityName, bool $validateWithSymfony = true): array
    {
        $fieldsToValidate = ValidationArrayKeys::validArrayAndReturnArrayKeys(array: $queryParams);

        $page        = $queryParams['page'] ?? 1;
        $per_page    = $queryParams['limit'] ?? 20;
        $searchField = $queryParams['search_field'] ?? '';
        $search      = $queryParams['search'] ?? '';
        $orderBy     = $queryParams['order'] ?? '';
        $sort        = $queryParams['sort'] ?? '';

        foreach ($fieldsToValidate as $key => $field) {
            if (! property_exists($entityName, $field)) {
                unset($queryParams[$field]);
                unset($fieldsToValidate[$key]);
            }
        }

        if($validateWithSymfony) {
            $this->validateSymfony(
                queryParams: $queryParams,
                fieldsToValidate: $fieldsToValidate,
                entityName: $entityName
            );
        }

        return [
            "queryParams"  => $queryParams,
            "page"         => $page,
            "limit"        => $per_page,
            "search_field" => $searchField,
            "search"       => $search,
            "order"      => $orderBy,
            "sort"         => $sort
        ];
    }

    private function validateSymfony(array $queryParams, array $fieldsToValidate, string $entityName):void
    {
        try {
            $object = $this->serializer->deserialize(
                json_encode($queryParams),
                $entityName,
                "json"
            );
        } catch (Exception $e) {
            throw new QueryParamsDeserializationException(
                message: "Erro ao tentar deserializar objeto",
                statusCode: StatusHttp::EXPECTATION_FAILED,
                internalMessageError: $e->getMessage()
            );
        }

        $messageError = "";

        $errors = $this->validator->validate($object);

        foreach ($errors as $error) {
            if (in_array($error->getPropertyPath(), $fieldsToValidate)) {
                $messageError .= sprintf("%s; ", $error->getMessage());
            }
        }

        if (! empty($messageError)) {
            throw new QueryParamsValidationException(
                message: $messageError,
                statusCode: StatusHttp::EXPECTATION_FAILED
            );
        }
    }
}
