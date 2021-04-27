<?php

declare(strict_types=1);

namespace App\ParamConverter\Entity;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class LoadSingleParamConverter extends EntityParamConverterBase
{
    protected const PARAM_NAME = 'entity';

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $type = $this->getType($request);
        $id = $this->getId($request);

        if ($type === null || $id === null) {
            return false;
        }

        $className = $this->getClassName($type);
        $entity = $this->getRepository($className)->find($id);

        if ($entity === null) {
            throw new NotFoundHttpException();
        }

        $request->attributes->set($configuration->getName(), $entity);

        return true;
    }
}