<?php


namespace App\Dto;

use DateTime;
use JMS\Serializer\Annotation\Type;

class Token
{
    /** @Type("integer") */
    private int $iduser;

    /** @Type("string") */
    private string $name;

    /** @Type("string") */
    private string|null $type = null;

    /** @Type("string") */
    private string $accesstoken;

    /** @Type("string") */
    private string $tokentype;

    /** @Type("DateTime<'d/m/Y H:i:s'>") */
    private DateTime $expiresin;

    public function getIduser(): int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): Token
    {
        $this->iduser = $iduser;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Token
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): string|null
    {
        return $this->type;
    }


    public function setType(string|null $type): Token
    {
        $this->type = $type;
        return $this;
    }

    public function getAccesstoken(): string
    {
        return $this->accesstoken;
    }

    public function setAccesstoken(string $accesstoken): Token
    {
        $this->accesstoken = $accesstoken;
        return $this;
    }

    public function getTokentype(): string
    {
        return $this->tokentype;
    }

    public function setTokentype(string $tokentype): Token
    {
        $this->tokentype = $tokentype;
        return $this;
    }

    public function getExpiresin(): DateTime
    {
        return $this->expiresin;
    }

    public function setExpiresin(DateTime $expiresin): Token
    {
        $this->expiresin = $expiresin;
        return $this;
    }
}
