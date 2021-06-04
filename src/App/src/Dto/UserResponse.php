<?php


namespace App\Dto;


use App\Entity\UserType;
use DateTime;

class UserResponse extends AbstractBaseDTO
{
    private int $id;

    private string|null $name = null;

    private string|null $login = null;

    private string|null $email = null;

    private string|null $cpf = null;

    private bool|null $status = null;

    private UserType|null $userType = null;

    private DateTime|null $createdAt = null;

    private DateTime|null $updatedAt = null;

    public function __construct(array|null $data = [])
    {
        parent::__construct(self::class, $data);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): UserResponse
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setName(string|null $name): UserResponse
    {
        $this->name = $name;
        return $this;
    }

    public function getLogin(): string|null
    {
        return $this->login;
    }

    public function setLogin(string|null $login): UserResponse
    {
        $this->login = $login;
        return $this;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }

    public function setEmail(string|null $email): UserResponse
    {
        $this->email = $email;
        return $this;
    }

    public function getCpf(): string|null
    {
        return $this->cpf;
    }

    public function setCpf(string|null $cpf): UserResponse
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getStatus(): bool|null
    {
        return $this->status;
    }

    public function setStatus(bool|null $status): UserResponse
    {
        $this->status = $status;
        return $this;
    }

    public function getUserType(): UserType|null
    {
        return $this->userType;
    }

    public function setUserType(UserType|null $userType): UserResponse
    {
        $this->userType = $userType;
        return $this;
    }

    public function getCreatedAt(): DateTime|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime|null $createdAt): UserResponse
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime|null
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime|null $updatedAt): UserResponse
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
