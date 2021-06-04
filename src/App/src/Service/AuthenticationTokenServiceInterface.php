<?php


namespace App\Service;


use App\Dto\Token;
use App\Entity\User;

interface AuthenticationTokenServiceInterface
{
    public const BEARER = "Bearer ";

    public function createUserToken(User $user): Token;

    public function createInternalUserToken(array|null $data = []): string;

    public function decode(string $jwtToken): object;

    public function getDefaultTimeZone(): mixed;
}
