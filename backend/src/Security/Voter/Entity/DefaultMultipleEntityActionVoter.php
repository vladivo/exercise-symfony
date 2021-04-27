<?php

declare(strict_types=1);

namespace App\Security\Voter\Entity;

use App\Entity\Entity;
use App\Model\User\User;
use App\Utils\Entity\TypeMapper\TypeToClassMapper;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use function assert;
use function sprintf;

final class DefaultMultipleEntityActionVoter extends Voter
{
    public function __construct(
        private TypeToClassMapper $typeToClassMapper,
    ) {}

    protected function supports(string $attribute, $subject): bool
    {
        return is_string($subject)
            && is_subclass_of($this->typeToClassMapper->getClass($subject), Entity::class);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        assert(is_string($subject));

        $user = $token->getUser();
        assert($user instanceof User);

        $permission = sprintf('%s_%s', $attribute, $subject);

        return $user->hasPermission($permission);
    }
}
