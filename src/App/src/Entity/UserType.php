<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Table(name="usertype")
 * @ORM\Entity(repositoryClass="App\Repository\UserTypeRepository")
 */
class UserType
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue("IDENTITY")
     *
     * @Type("int")
     * @Assert\NotNull(message="O id é obrigatório")
     */
    private int $id;

    /**
     * @ORM\Column(name="description", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="A descrição é obrigatória")
     * @Assert\NotBlank(message="A descrição não pode ser vazia")
     */
    private string|null $description = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): UserType
    {
        $this->id = $id;
        return $this;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function setDescription(string|null $description): UserType
    {
        $this->description = $description;
        return $this;
    }


}
