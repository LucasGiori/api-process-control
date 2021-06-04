<?php


namespace App\Service;


use App\Dto\Token;
use App\Entity\User;
use App\Exceptions\CreateTokenException;
use App\Exceptions\ExpiredTokenException;
use App\Exceptions\InvalidTokenException;
use App\Utils\Jwt\JWTFactory;
use App\Utils\Token\TokenData;
use DateTime;
use Exception;
use Firebase\JWT\ExpiredException;
use Http\StatusHttp;
use Throwable;

class AuthenticationTokenService implements AuthenticationTokenServiceInterface
{
    private JWTFactory $jwt;

    private array $tokenData;

    private string $algorithm;

    private string $key;

    private string $timezone;

    private int $expiration;

    private bool $defaultTimeZone;

    public function __construct()
    {
        $this->jwt             = new JWTFactory();
        $this->tokenData       = TokenData::getUserTokenData();
        $this->algorithm       = $this->tokenData["algorithm"];
        $this->key             = $this->tokenData["key"];
        $this->timezone        = $this->tokenData["timezone"];
        $this->expiration      = $this->tokenData["expiration"];
        $this->defaultTimeZone = date_default_timezone_set($this->timezone);
    }


    public function createUserToken(User $user): Token
    {
        try {
            if (empty($user) || (empty($user->getId()))) {
                throw new CreateTokenException(
                    message: "Os dados do usuário estão inválidos!",
                    statusCode: StatusHttp::BAD_REQUEST
                );
            }

            $iduser = $user->getId();

            $payload = $this->generatePayload([
                "iduser"    => $iduser,
                "name"      => $user->getName(),
                "login"     => $user->getLogin()
            ]);

            $dateExpiresToken = (new DateTime())->setTimestamp($payload["exp"]);

            return (new Token())
                ->setIdUser($iduser)
                ->setName($user->getName())
                ->setType($user->getUserType()->getId())
                ->setAccessToken($this->encode($payload))
                ->setTokenType(trim(self::BEARER))
                ->setExpiresIn($dateExpiresToken);
        } catch (Throwable $e) {
            throw new CreateTokenException(
                message: "Erro ao tentar criar token!",
                statusCode: StatusHttp::BAD_REQUEST,
                internalMessageError: $e->getMessage()
            );
        }
    }

    private function encode(array $payload): string
    {
        return $this->jwt->encode($payload, $this->key, $this->algorithm);
    }

    public function createInternalUserToken(array|null $data = []): string
    {
        if (empty($data)) {
            $data = ["iduser" => 1, "name" => "admin"];
        }

        return sprintf("Bearer %s" , $this->encode($this->generatePayload($data)));
    }

    public function decode(string $jwtToken): object
    {
        try {
            return $this->jwt->decode($jwtToken, $this->key, [$this->algorithm]);
        } catch (ExpiredException) {
            throw new ExpiredTokenException( message: "Token Expirado!", statusCode: StatusHttp::UNAUTHORIZED);
        } catch (Exception) {
            throw new InvalidTokenException(message: "Token inválido", statusCode: StatusHttp::UNAUTHORIZED);
        }
    }

    private function generatePayload(array $data): array
    {
        $createdAt      = time();
        $expirationTime = $createdAt + $this->expiration;

        return [
            "iss"  => $_SERVER["SERVER_NAME"] ?? "",
            "iat"  => $createdAt,
            "nbf"  => $createdAt,
            "exp"  => $expirationTime,
            "data" => $data,
        ];
    }

    /**
     * @return mixed
     */
    public function getDefaultTimeZone(): mixed
    {
        return $this->defaultTimeZone;
    }
}
