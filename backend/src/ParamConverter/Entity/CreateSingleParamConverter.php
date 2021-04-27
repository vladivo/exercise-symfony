<?php

declare(strict_types=1);

namespace App\ParamConverter\Entity;

use App\Utils\Entity\Instantiator\Instantiator;
use App\Utils\Entity\TypeMapper\TypeToClassMapper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

final class CreateSingleParamConverter extends EntityParamConverterBase
{
    protected const PARAM_NAME = 'newEntity';

    public function __construct(
        TypeToClassMapper $typeToClassMapper,
        EntityManagerInterface $entityManager,
        private Instantiator $instantiator,
    ) {
        parent::__construct($typeToClassMapper, $entityManager);
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $type = $this->getType($request);

        if ($type === null) {
            return false;
        }

        $className = $this->getClassName($type);
        $entity = $this->instantiator->instantiate($className);

        $request->attributes->set($configuration->getName(), $entity);

        return true;
    }
}