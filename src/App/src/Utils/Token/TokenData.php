<?php


namespace App\Utils\Token;

use ApiCore\LoadConfigData;

class TokenData extends LoadConfigData
{
    public static function getUserTokenData(): array
    {
        return self::getConfig("jwt");
    }
}
