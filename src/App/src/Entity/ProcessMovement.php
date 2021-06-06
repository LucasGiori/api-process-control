<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="processmovement")
 * @ORM\Entity(repositoryClass="App\Repository\ProcessRepository")
 */
class ProcessMovement
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Process", inversedBy="movements")
     * @ORM\JoinColumn(name="processid", referencedColumnName="id")
     *
     * @Type("App\Entity\Process")
     * @Assert\NotNull(message="O processo é obrigatório")
     */
    private Process|null $process = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Company")
     * @ORM\JoinColumn(name="officeid", referencedColumnName="id")
     *
     * @Type("App\Entity\Company")
     * @Assert\NotNull(message="O Escritório é obrigatório")
     */
    private Company|null $office = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Attorney")
     * @ORM\JoinColumn(name="attorneyid", referencedColumnName="id")
     *
     * @Type("App\Entity\Attorney")
     * @Assert\NotNull(message="O Advogado é obrigatório")
     */
    private Attorney|null $attorney = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="userid", referencedColumnName="id")
     *
     * @Type("App\Entity\User")
     * @Assert\NotNull(message="O usuário é obrigatório")
     */
    private User|null $user = null;

    /**
     * @ORM\Column(name="links", type="string", nullable=true)
     *
     * @Type("string")
     */
    private string|null $links = null;

    /**
     * @ORM\Column(name="stageprocess", type="string", nullable=true)
     *
     * @Type("string")
     */
    private string|null $stageProcess = null;

    /**
     * @ORM\Column(name="comment", type="string", nullable=true)
     *
     * @Type("string")
     */
    private string|null $comment = null;

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

    public function setId(int $id): ProcessMovement
    {
        $this->id = $id;
        return $this;
    }

    public function getProcess(): Process|null
    {
        return $this->process;
    }

    public function setProcess(Process|null $process): ProcessMovement
    {
        $this->process = $process;
        return $this;
    }

    public function getOffice(): Company|null
    {
        return $this->office;
    }

    public function setOffice(Company|null $office): ProcessMovement
    {
        $this->office = $office;
        return $this;
    }

    public function getAttorney(): Attorney|null
    {
        return $this->attorney;
    }

    public function setAttorney(Attorney|null $attorney): ProcessMovement
    {
        $this->attorney = $attorney;
        return $this;
    }

    public function getUser(): User|null
    {
        return $this->user;
    }

    public function setUser(User|null $user): ProcessMovement
    {
        $this->user = $user;
        return $this;
    }

    public function getLinks(): string|null
    {
        return $this->links;
    }

    public function setLinks(string|null $links): ProcessMovement
    {
        $this->links = $links;
        return $this;
    }

    public function getStageProcess(): string|null
    {
        return $this->stageProcess;
    }

    public function setStageProcess(string|null $stageProcess): ProcessMovement
    {
        $this->stageProcess = $stageProcess;
        return $this;
    }

    public function getComment(): string|null
    {
        return $this->comment;
    }

    public function setComment(string|null $comment): ProcessMovement
    {
        $this->comment = $comment;
        return $this;
    }

    public function getCreatedAt(): DateTime|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime|null $createdAt): ProcessMovement
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime|null
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime|null $updatedAt): ProcessMovement
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
