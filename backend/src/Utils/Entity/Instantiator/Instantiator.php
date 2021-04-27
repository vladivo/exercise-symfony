<?php

declare(strict_types=1);

namespace App\Utils\Entity\Instantiator;

use App\Entity\Entity;

interface Instantiator
{
    public function instantiate(string $className): Entity;
}
