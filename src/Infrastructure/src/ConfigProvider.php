<?php

namespace Infrastructure;

use Infrastructure\Api\Middleware\LoadConfigDataMiddleware;
use Infrastructure\Api\Middleware\LoadConfigDataMiddlewareFactory;
use Infrastructure\Container\CorsMiddlewareFactory;
use Infrastructure\HttpRequest\HttpRequest;
use Infrastructure\HttpRequest\HttRequestFactory;
use Infrastructure\Utils\QueryParams\QueryParamsValidation;
use Infrastructure\Utils\QueryParams\QueryParamsValidationFactory;
use Infrastructure\Utils\Serializer\Deserialization;
use Infrastructure\Utils\Serializer\DeserializationFactory;
use Infrastructure\Utils\Validation\ValidationSymfony;
use Infrastructure\Utils\Validation\ValidationSymfonyFactory;
use Tuupola\Middleware\CorsMiddleware;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'invokables' => [],
            'factories'  => [
                QueryParamsValidation::class    => QueryParamsValidationFactory::class,
                ValidationSymfony::class        => ValidationSymfonyFactory::class,
                CorsMiddleware::class           => CorsMiddlewareFactory::class,
                LoadConfigDataMiddleware::class => LoadConfigDataMiddlewareFactory::class,
                Deserialization::class          => DeserializationFactory::class
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [];
    }
}
