<?php

declare(strict_types=1);

namespace App\ParamConverter\Security;

use App\Repository\User\AccountRepository;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

final class ResetPasswordParamConverter implements ParamConverterInterface
{
    private const PARAM_NAME = 'requestedAccount';

    public function __construct(
        private SerializerInterface $serializer,
        private AccountRepository $accountRepository,
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
            return true;
        }

        if (!isset($data['mail'])) {
            return true;
        }

        $account = $this->accountRepository->findOneBy(['mail' => $data['mail']]);

        if ($account === null || !$account->isEnabled()) {
            return true;
        }

        $request->attributes->set($configuration->getName(), $account);

        return true;
    }
}
