<?php

namespace Infrastructure\Utils;

use ApiCore\LoadConfigData;

class SentryConfig extends LoadConfigData
{
    public static function getOptions(): array
    {
        return self::getConfig("sentry");
    }

    public static function getEnvironment(): string
    {
        return self::getConfig("api_information", "environment");
    }

    public static function getServerName(): string
    {
        return self::getConfig("internal_host");
    }
}
