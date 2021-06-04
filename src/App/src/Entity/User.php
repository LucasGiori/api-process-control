<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use ReflectionClass;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="login", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O login é obrigatório")
     * @Assert\NotBlank(message="O login não pode ser vazio")
     */
    private string|null $login = null;

    /**
     * @ORM\Column(name="email", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O email é obrigatório")
     * @Assert\NotBlank(message="O email não pode ser vazio")
     * @Assert\Email(message="O email '{{ value }}' não é válido")
     */
    private string|null $email = null;

    /**
     * @ORM\Column(name="cpf", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="O cpf é obrigatório")
     * @Assert\NotBlank(message="O cpf não pode ser vazio")
     * @Assert\Length(
     *      min = 11,
     *      max = 11,
     *      minMessage = "O Cpf precisa ter no mínimo {{ limit }} caracteres",
     *      maxMessage = "O Cpf pode ter no máximo {{ limit }} caracteres"
     * )
     */
    private string|null $cpf = null;

    /**
     * @ORM\Column(name="password", type="string", nullable=false)
     *
     * @Type("string")
     * @Assert\NotNull(message="A senha é obrigatório")
     * @Assert\NotBlank(message="A senha não pode ser vazio")
     * @Assert\Length(
     *      min = 8,
     *      max = 35,
     *      minMessage = "A senha precisa ter no mínimo {{ limit }} caracteres",
     *      maxMessage = "A senha pode ter no máximo {{ limit }} caracteres"
     * )
     */
    private string|null $password = null;

    /**
     * @ORM\Column(name="status", type="boolean", nullable=false)
     *
     * @Type("boolean")
     * @Assert\NotNull(message="O status é obrigatório")
     */
    private bool|null $status = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserType")
     * @ORM\JoinColumn(name="usertypeid", referencedColumnName="id")
     *
     * @Type("App\Entity\UserType")
     * @Assert\NotNull(message="O tipo de usuário é obrigatório")
     */
    private UserType|null $userType = null;

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

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function setName(string|null $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getLogin(): string|null
    {
        return $this->login;
    }

    public function setLogin(string|null $login): User
    {
        $this->login = $login;
        return $this;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }

    public function setEmail(string|null $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getCpf(): string|null
    {
        return $this->cpf;
    }

    public function setCpf(string|null $cpf): User
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function setPassword(string|null $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getStatus(): bool|null
    {
        return $this->status;
    }

    public function setStatus(bool|null $status): User
    {
        $this->status = $status;
        return $this;
    }

    public function getUserType(): UserType|null
    {
        return $this->userType;
    }

    public function setUserType(UserType|null $userType): User
    {
        $this->userType = $userType;
        return $this;
    }

    public function getCreatedAt(): DateTime|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime|null $createdAt): User
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime|null
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime|null $updatedAt): User
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function toArray(): array
    {
        $array = [];
        $class = new ReflectionClass($this);
        foreach ($class->getProperties() as $value) {
            $value->setAccessible(true);
            $array[$value->getName()] = $value->getValue($this);
        }

        return $array;
    }

}
