<?php

declare(strict_types=1);

namespace App\ParamConverter\Security;

use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

final class UpdatePasswordParamConverter implements ParamConverterInterface
{
    private const PARAM_NAME = 'newPassword';

    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getName() === self::PARAM_NAME;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        try {
            $data = $this->serializer->deserialize($request->getContent(), 'array', 'json');
        } catch (Throwable) {
            throw new BadRequestHttpException();
        }

        if (!isset($data['password'])) {
            throw new BadRequestHttpException();
        }

        $request->attributes->set($configuration->getName(), $data['password']);

        return true;
    }
}
