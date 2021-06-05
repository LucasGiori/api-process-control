<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="typeaction")
 * @ORM\Entity(repositoryClass="App\Repository\ActionTypeRepository")
 */
class ActionType
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
     * @Assert\NotNull(message="A descrição é obrigatório")
     * @Assert\NotBlank(message="A descriçõo não pode ser vazio")
     */
    private string|null $description = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): ActionType
    {
        $this->id = $id;
        return $this;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function setDescription(string|null $description): ActionType
    {
        $this->description = $description;
        return $this;
    }


}
