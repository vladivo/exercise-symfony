<?php

declare(strict_types=1);

namespace App\Attribute;

use Attribute;
use InvalidArgumentException;
use Symfony\Component\Form\FormTypeInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class PropertyFormField
{
    public function __construct(
        private string $type,
        private array $options = [],
    ) {
        if ($type !== null && !is_subclass_of($type, FormTypeInterface::class)) {
            throw new InvalidArgumentException('$type must be a subclass of FormTypeInterface');
        }
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
