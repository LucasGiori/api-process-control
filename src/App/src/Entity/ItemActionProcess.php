<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="itemactionprocess")
 * @ORM\Entity(repositoryClass="App\Repository\ItemActionProcessProcessRepository")
 */
class ItemActionProcess
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
     * @ORM\OneToOne(targetEntity="App\Entity\Action")
     * @ORM\JoinColumn(name="idaction", referencedColumnName="id")
     *
     * @Type("App\Entity\Action")
     * @Assert\NotNull(message="A Ação é obrigatória")
     */
    private Action|null $action = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Process", inversedBy="items")
     * @ORM\JoinColumn(name="idprocess", referencedColumnName="id")
     *
     * @Type("App\Entity\Process")
     * @Assert\NotNull(message="O processo é obrigatório")
     */
    private Process|null $process = null;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAction(): Action|null
    {
        return $this->action;
    }

    public function setAction(Action|null $action): void
    {
        $this->action = $action;
    }

    public function getProcess(): Process|null
    {
        return $this->process;
    }

    public function setProcess(Process|null $process): ItemActionProcess
    {
        $this->process = $process;
        return $this;
    }
}
