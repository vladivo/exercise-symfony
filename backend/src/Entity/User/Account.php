<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Attribute\EntityPermissions;
use App\Attribute\PropertyFormField;
use App\Repository\User\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
#[UniqueEntity('mail')]
#[EntityPermissions]
final class Account extends UserEntityBase
{
    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 255)]
    #[PropertyFormField(TextType::class)]
    private string $mail;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    #[Assert\Type('bool')]
    #[PropertyFormField(CheckboxType::class)]
    private bool $enabled;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @JMS\Exclude()
     */
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 1024)]
    #[PropertyFormField(PasswordType::class)]
    private string $password;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="user_roles",
     *      joinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role", referencedColumnName="id", onDelete="CASCADE")}
     * )
     * @JMS\Type("ArrayCollection<Relation>")
     * @var Collection<Role>
     */
    #[Assert\Unique]
    #[PropertyFormField(EntityType::class, ['class' => Role::class, 'multiple' => true])]
    private Collection $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getMail(): string
    {
        return $this->mail;
    }
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return Collection<Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    /**
     * @param Collection<Role> $roles
     */
    public function setRoles(Collection $roles): void
    {
        $this->roles = $roles;
    }
}
