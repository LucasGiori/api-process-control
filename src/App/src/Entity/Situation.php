<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="situation")
 * @ORM\Entity(repositoryClass="App\Repository\SituationRepository")
 */
class Situation
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
     * @ORM\Column(name="description", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="A descrição da situação não pode ser nula")
     */
    private string|null $description;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Situation
    {
        $this->id = $id;
        return $this;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function setDescription(string|null $description): Situation
    {
        $this->description = $description;
        return $this;
    }
}
