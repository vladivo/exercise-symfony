<?php

declare(strict_types=1);

namespace App\ParamConverter\Entity;

use App\Utils\Entity\TypeMapper\TypeToClassMapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class EntityParamConverterBase implements ParamConverterInterface
{
    private const ATTR_TYPE = 'type';
    private const ATTR_ID = 'id';

    private TypeToClassMapper $typeToClassMapper;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TypeToClassMapper $typeToClassMapper,
        EntityManagerInterface $entityManager,
    ) {
        $this->typeToClassMapper = $typeToClassMapper;
        $this->entityManager = $entityManager;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getName() === static::PARAM_NAME;
    }

    protected function getType(Request $request): ?string
    {
        return $request->attributes->get(self::ATTR_TYPE);
    }

    protected function getId(Request $request): ?string
    {
        return $request->attributes->get(self::ATTR_ID);
    }

    protected function getClassName(string $type): string
    {
        $className = $this->typeToClassMapper->getClass($type);

        if ($className === null) {
            throw new NotFoundHttpException();
        }

        return $className;
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function getRepository(string $className): ObjectRepository
    {
        return $this->entityManager->getRepository($className);
    }
}