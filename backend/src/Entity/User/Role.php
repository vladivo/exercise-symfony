<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Attribute\EntityPermissions;
use App\Attribute\PropertyFormField;
use App\Repository\User\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
#[EntityPermissions]
final class Role extends UserEntityBase
{
    public const ID_ANONYMOUS = 1;
    public const ID_AUTHENTICATED = 2;
    public const ID_ADMINISTRATOR = 3;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[PropertyFormField(TextType::class)]
    private string $title;

    /**
     * @ORM\ManyToMany(targetEntity="Permission")
     * @ORM\JoinTable(name="role_permissions",
     *      joinColumns={@ORM\JoinColumn(name="role", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="permission", referencedColumnName="id", onDelete="CASCADE")}
     * )
     * @JMS\Type("ArrayCollection<Relation>")
     *
     * @var Collection<Permission>
     */
    #[Assert\Unique]
    #[PropertyFormField(EntityType::class, ['class' => Permission::class, 'multiple' => true])]
    private Collection $permissions;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Collection<Permission>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function setPermissions(Collection $permissions): void
    {
        $this->permissions = $permissions;
    }
}
