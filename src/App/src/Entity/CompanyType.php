<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="companytype")
 * @ORM\Entity(repositoryClass="App\Repository\CompanyTypeRepository")
 */
class CompanyType
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
     * @Assert\NotNull(message="O nome do tipo da empresa é obrigatório")
     */
    private string|null $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): CompanyType
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setName(string|null $name): CompanyType
    {
        $this->name = $name;
        return $this;
    }
}
