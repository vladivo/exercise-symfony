<?php

declare(strict_types=1);

namespace App\Entity;

interface Entity
{
    public function getClass(): string;
    public function getType(): string;
    public function getId(): ?int;
    public function isInternal(): bool;
    public function setInternal(bool $internal): void;
}
