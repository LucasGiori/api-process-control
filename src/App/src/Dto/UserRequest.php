<?php


namespace App\Dto;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest extends AbstractBaseDTO
{
    /**
     * @Type("string")
     * @Assert\NotNull(message="O login é obrigatório")
     * @Assert\NotBlank(message="O login não pode ser vazio")
     */
    private string|null $login = null;

    /**
     * @Type("string")
     * @Assert\NotNull(message="A senha é obrigatório")
     * @Assert\NotBlank(message="A senha não pode ser vazio")
     */
    private string|null $password = null;

    public function getLogin(): string|null
    {
        return $this->login;
    }

    public function setLogin(string|null $login): UserRequest
    {
        $this->login = $login;
        return $this;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function setPassword(string|null $password): UserRequest
    {
        $this->password = $password;
        return $this;
    }
}
