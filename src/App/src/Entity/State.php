<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="state")
 * @ORM\Entity(repositoryClass="App\Repository\StateRepository")
 */
class State
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue("IDENTITY")
     *
     * @Type("int")
     */
    private int $id;

    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O nome do estado é obrigatória")
     */
    private string|null $name;

    /**
     * @ORM\Column(name="uf", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="A Uf é obrigatória")
     */
    private string|null $uf;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): State
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setName(string|null $name): State
    {
        $this->name = $name;
        return $this;
    }

    public function getUf(): string|null
    {
        return $this->uf;
    }

    public function setUf(string|null $uf): void
    {
        $this->uf = $uf;
    }
}
