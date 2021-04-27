<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Attribute\PropertyFormField;
use App\Entity\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
#[UniqueEntity('name')]
abstract class UserEntityBase extends EntityBase
{
    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[Assert\Regex('/^[a-z_]+$/')]
    #[PropertyFormField(TextType::class)]
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}