<?php

declare(strict_types=1);

namespace App\Model\Form;

final class FormInput
{
    private function __construct(
        private array $data,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function create(array $data): self
    {
        return new self($data);
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }
}
