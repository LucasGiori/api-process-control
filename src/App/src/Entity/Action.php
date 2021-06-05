<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="action")
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 */
class Action
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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ActionType")
     * @ORM\JoinColumn(name="typeactionid", referencedColumnName="id")
     *
     * @Type("App\Entity\ActionType")
     * @Assert\NotNull(message="O tipo de ação é obrigatória")
     */
    private ActionType|null $actionType = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Situation")
     * @ORM\JoinColumn(name="situationid", referencedColumnName="id")
     *
     * @Type("App\Entity\Situation")
     * @Assert\NotNull(message="A situação é obrigatória")
     */
    private Situation|null $situation = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Action
    {
        $this->id = $id;
        return $this;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function setDescription(string|null $description): Action
    {
        $this->description = $description;
        return $this;
    }

    public function getActionType(): ActionType|null
    {
        return $this->actionType;
    }

    public function setActionType(ActionType|null $actionType): Action
    {
        $this->actionType = $actionType;
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
