<?php

declare(strict_types=1);

namespace App\Utils\Entity\Instantiator;

use App\Entity\Entity;
use Doctrine\Instantiator\Instantiator as DoctrineInstantiator;
use LogicException;

final class DoctrineBasedInstantiator implements Instantiator
{
    public function instantiate(string $className): Entity
    {
        if (!is_subclass_of($className, Entity::class)) {
            throw new LogicException('$className must be a subclass of Entity');
        }

        $instantiator = new DoctrineInstantiator();

        return $instantiator->instantiate($className);
    }
}
