<?php


namespace App\Entity;


use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="process")
 * @ORM\Entity(repositoryClass="App\Repository\ProcessRepository")
 */
class Process
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
     * @ORM\Column(name="number", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O número do processo é obrigatório")
     * @Assert\NotBlank(message="O número do processo não pode ser vazio")
     */
    private string|null $number = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Company")
     * @ORM\JoinColumn(name="companyid", referencedColumnName="id")
     *
     * @Type("App\Entity\Company")
     * @Assert\NotNull(message="A empresa é obrigatório")
     */
    private Company|null $company = null;

    /**
     * @ORM\Column(name="notificationdate", type="datetime")
     *
     * @Type("DateTime<'d/m/Y h:m:s'>")
     */
    private DateTime|null $notificationDate = null;

    /**
     * @ORM\Column(name="description", type="string", nullable=true)
     *
     * @Type("string")
     */
    private string|null $description = null;

    /**
     * @ORM\Column(name="observation", type="string")
     *
     * @Type("string")
     */
    private string|null $observation = null;

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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="userid", referencedColumnName="id")
     *
     * @Type("App\Entity\User")
     * @Assert\NotNull(message="O usuário é obrigatória")
     */
    private User|null $user = null;

    /**
     * @ORM\Column(name="status", type="boolean")
     *
     * @Type("boolean")
     * @Assert\NotNull(message="o Status é obrigatório")
     */
    private bool|null $status = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProcessMovement", mappedBy="process", cascade={"persist"})
     *
     * @Type("ArrayCollection<App\Entity\ProcessMovement>")
     */
    private Collection|null $movements = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ItemActionProcess", mappedBy="process", cascade={"persist"})
     *
     * @Type("ArrayCollection<App\Entity\ItemActionProcess>")
     */
    private Collection|null $items = null;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Process
    {
        $this->id = $id;
        return $this;
    }

    public function getNumber(): string|null
    {
        return $this->number;
    }

    public function setNumber(string|null $number): Process
    {
        $this->number = $number;
        return $this;
    }

    public function getCompany(): Company|null
    {
        return $this->company;
    }

    public function setCompany(Company|null $company): Process
    {
        $this->company = $company;
        return $this;
    }

    public function getNotificationDate(): DateTime|null
    {
        return $this->notificationDate;
    }

    public function setNotificationDate(DateTime|null $notificationDate): Process
    {
        $this->notificationDate = $notificationDate;
        return $this;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function setDescription(string|null $description): Process
    {
        $this->description = $description;
        return $this;
    }

    public function getObservation(): string|null
    {
        return $this->observation;
    }

    public function setObservation(string|null $observation): Process
    {
        $this->observation = $observation;
        return $this;
    }

    public function getCreatedAt(): DateTime|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime|null $createdAt): Process
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime|null
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime|null $updatedAt): Process
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getStatus(): bool|null
    {
        return $this->status;
    }

    public function setStatus(bool|null $status): void
    {
        $this->status = $status;
    }

    public function getUser(): User|null
    {
        return $this->user;
    }

    public function setUser(User|null $user): void
    {
        $this->user = $user;
    }

    public function getMovements(): Collection|null
    {
        return $this->movements;
    }

    public function setMovements(Collection|null $movements): void
    {
        $this->movements = $movements;
    }

    public function getItems(): Collection|null
    {
        return $this->items;
    }

    public function setItems(Collection|null $items): void
    {
        $this->items = $items;
    }
}
