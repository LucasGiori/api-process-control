<?php


namespace App\Service;


class AuthenticationTokenServiceFactory
{
    public function __invoke(): AuthenticationTokenService
    {
        return new AuthenticationTokenService();
    }
}
