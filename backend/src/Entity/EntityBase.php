<?php

declare(strict_types=1);

namespace App\Entity;

use App\Utils\Entity\TypeMapper\DefaultTypeMapper;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\MappedSuperclass
 */
abstract class EntityBase implements Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $internal = false;

    public function getClass(): string
    {
        return static::class;
    }

    /**
     * @JMS\VirtualProperty
     */
    public function getType(): string
    {
        return DefaultTypeMapper::mapClassToType(static::class);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isInternal(): bool
    {
        return $this->internal;
    }

    public function setInternal(bool $internal): void
    {
        $this->internal = $internal;
    }
}
