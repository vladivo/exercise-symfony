<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Model\Form\FormInput;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

final class FormInputParamConverter implements ParamConverterInterface
{
    private const PARAM_NAME = 'formInput';

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

        $request->attributes->set($configuration->getName(), FormInput::create($data));

        return true;
    }
}