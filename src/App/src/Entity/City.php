<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
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
     * @ORM\Column(name="name", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O nome da cidade é obrigatório")
     */
    private string|null $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     *
     * @Type("App\Entity\State")
     * @Assert\NotNull(message="O estado é obrigatório")
     */
    private State|null $state;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): City
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setName(string|null $name): City
    {
        $this->name = $name;
        return $this;
    }

    public function getState(): State|null
    {
        return $this->state;
    }

    public function setState(State|null $state): City
    {
        $this->state = $state;
        return $this;
    }
}
