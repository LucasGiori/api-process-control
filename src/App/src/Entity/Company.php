<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
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
     * @ORM\Column(name="namefantasy", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O nome fantasia é obrigatório")
     */
    private string|null $nameFantasy = null;

    /**
     * @ORM\Column(name="companyname", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O nome da empresa é obrigatório")
     */
    private string|null $companyName = null;

    /**
     * @ORM\Column(name="cnpj", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O cnpj é obrigatório")
     * @Assert\Length(
     *     min=14,
     *     max=14,
     *     minMessage="O cnpj precisa ter 14 caracteres",
     *     maxMessage="O cnpj precisa ter 14 caracteres"
     * )
     */
    private string|null $cnpj = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\City")
     * @ORM\JoinColumn(name="cityid", referencedColumnName="id")
     *
     * @Type("App\Entity\City")
     * @Assert\NotNull(message="A Cidade é obrigatória")
     */
    private City|null $city;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CompanyType")
     * @ORM\JoinColumn(name="companytypeid", referencedColumnName="id")
     *
     * @Type("App\Entity\CompanyType")
     * @Assert\NotNull(message="O tipo da empresa é obrigatória")
     */
    private CompanyType|null $companyType;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Situation")
     * @ORM\JoinColumn(name="situationid", referencedColumnName="id")
     *
     * @Type("App\Entity\Situation")
     * @Assert\NotNull(message="A situação da empresa é obrigatória")
     */
    private Situation|null $situation = null;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Type("DateTime<'d/m/Y h:m:s'>")
     */
    private DateTime|null $createdAt = null;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     *
     * @Type("DateTime<'d/m/Y h:m:s'>")
     */
    private DateTime|null $updatedAt = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Company
    {
        $this->id = $id;
        return $this;
    }

    public function getNameFantasy(): string|null
    {
        return $this->nameFantasy;
    }

    public function setNameFantasy(string|null $nameFantasy): Company
    {
        $this->nameFantasy = $nameFantasy;
        return $this;
    }

    public function getCompanyName(): string|null
    {
        return $this->companyName;
    }

    public function setCompanyName(string|null $companyName): Company
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function getCnpj(): string|null
    {
        return $this->cnpj;
    }

    public function setCnpj(string|null $cnpj): void
    {
        $this->cnpj = $cnpj;
    }

    public function getCity(): City|null
    {
        return $this->city;
    }

    public function setCity(City|null $city): Company
    {
        $this->city = $city;
        return $this;
    }

    public function getCompanyType(): CompanyType|null
    {
        return $this->companyType;
    }

    public function setCompanyType(CompanyType|null $companyType): Company
    {
        $this->companyType = $companyType;
        return $this;
    }

    public function getSituation(): Situation|null
    {
        return $this->situation;
    }

    public function setSituation(Situation|null $situation): Company
    {
        $this->situation = $situation;
        return $this;
    }

    public function getCreatedAt(): DateTime|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime|null $createdAt): Company
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime|null
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime|null $updatedAt): Company
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


}
