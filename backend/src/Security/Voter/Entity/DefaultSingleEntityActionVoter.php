<?php

declare(strict_types=1);

namespace App\Security\Voter\Entity;

use App\Entity\Entity;
use App\Model\Permission\EntityAction;
use App\Model\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use function assert;
use function in_array;
use function sprintf;

final class DefaultSingleEntityActionVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, EntityAction::getCategory(EntityAction::CATEGORY_DEFAULT))
            && $subject instanceof Entity;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        assert($subject instanceof Entity);

        if ($attribute === EntityAction::DELETE && $subject->isInternal()) {
            return false;
        }

        $user = $token->getUser();
        assert($user instanceof User);

        $permission = sprintf('%s_%s', $attribute, $subject->getType());

        return $user->hasPermission($permission);
    }
}
