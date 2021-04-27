<?php

declare(strict_types=1);

namespace App\ParamConverter\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

final class LoadMultipleParamConverter extends EntityParamConverterBase
{
    protected const PARAM_NAME = 'entities';

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $type = $this->getType($request);

        if ($type === null) {
            return false;
        }

        $className = $this->getClassName($type);
        $entities = $this->getRepository($className)->findAll();
        $collection = new ArrayCollection($entities);

        $request->attributes->set($configuration->getName(), $collection);

        return true;
    }
}