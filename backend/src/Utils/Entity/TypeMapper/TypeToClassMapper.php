<?php

declare(strict_types=1);

namespace App\Utils\Entity\TypeMapper;

interface TypeToClassMapper
{
    public function getClass(string $type): ?string;
}
