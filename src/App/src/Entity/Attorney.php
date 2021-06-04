<?php


namespace App\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="attorney")
 * @ORM\Entity(repositoryClass="App\Repository\AttorneyRepository")
 */
class Attorney
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
     * @Assert\NotNull(message="O nome é obrigatório")
     * @Assert\NotBlank(message="O nome não pode ser vazio")
     */
    private string|null $name = null;

    /**
     * @ORM\Column(name="cpf", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O cpf é obrigatório")
     * @Assert\NotBlank(message="O cpf não pode ser vazio")
     * @Assert\Length(
     *      min = 11,
     *      max = 11,
     *      minMessage = "O cpf precisa de 11 caracteres",
     *      maxMessage = "O cpf precisa de ter apenas 11 caracteres"
     * )
     */
    private string|null $cpf = null;

    /**
     * @ORM\Column(name="oab", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O número oab é obrigatório")
     * @Assert\NotBlank(message="O número oab não pode ser vazio")
     */
    private string|null $oab = null;

    /**
     * @ORM\Column(name="phone", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O telefone  é obrigatório")
     * @Assert\NotBlank(message="O telefone não pode ser vazio")
     */
    private string|null $phone = null;

    /**
     * @ORM\Column(name="email", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O email  é obrigatório")
     * @Assert\NotBlank(message="O email não pode ser vazio")
     * @Assert\Email(message = "O email '{{ value }}' não é válido")
     */
    private string|null $email = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\City")
     * @ORM\JoinColumn(name="cityid", referencedColumnName="id")
     *
     * @Type("App\Entity\City")
     * @Assert\NotNull(message="A Cidade é obrigatória")
     */
    private City|null $city = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Company")
     * @ORM\JoinColumn(name="companyid", referencedColumnName="id")
     *
     * @Type("App\Entity\Company")
     * @Assert\NotNull(message="O Escritório do advogado é obrigatório")
     */
    private Company|null $office = null;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Type("DateTime<'d/m/Y h:m:s'>")
     */
    private DateTime|null $createdAt = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Situation")
     * @ORM\JoinColumn(name="situationid", referencedColumnName="id")
     *
     * @Type("App\Entity\Situation")
     * @Assert\NotNull(message="A situação do advogado é obrigatória")
     */
    private Situation|null $situation = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Attorney
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setName(string|null $name): Attorney
    {
        $this->name = $name;
        return $this;
    }

    public function getCpf(): string|null
    {
        return $this->cpf;
    }

    public function setCpf(string|null $cpf): Attorney
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getOab(): string|null
    {
        return $this->oab;
    }

    public function setOab(string|null $oab): Attorney
    {
        $this->oab = $oab;
        return $this;
    }

    public function getPhone(): string|null
    {
        return $this->phone;
    }

    public function setPhone(string|null $phone): Attorney
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }

    public function setEmail(string|null $email): Attorney
    {
        $this->email = $email;
        return $this;
    }

    public function getCity(): City|null
    {
        return $this->city;
    }

    public function setCity(City|null $city): Attorney
    {
        $this->city = $city;
        return $this;
    }

    public function getOffice(): Company|null
    {
        return $this->office;
    }

    public function setOffice(Company|null $office): Attorney
    {
        $this->office = $office;
        return $this;
    }

    public function getCreatedAt(): DateTime|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime|null $createdAt): Attorney
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getSituation(): Situation|null
    {
        return $this->situation;
    }

    public function setSituation(Situation|null $situation): void
    {
        $this->situation = $situation;
    }
}
