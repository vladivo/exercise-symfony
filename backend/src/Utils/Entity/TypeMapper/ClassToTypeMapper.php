<?php

declare(strict_types=1);

namespace App\Utils\Entity\TypeMapper;

interface ClassToTypeMapper
{
    public function getType(string $className): ?string;
}
