<?php

declare(strict_types=1);

namespace App\EntityListener\User;

use App\Entity\User\Account;
use App\Model\User\SystemUser;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class AccountListener
{
    public function __construct(
        private UserPasswordEncoderInterface $passwordEncoder,
    ) {}

    public function prePersist(Account $account): void
    {
        $encodedPassword = $this->encodePassword($account);
        $account->setPassword($encodedPassword);
    }

    public function preUpdate(Account $account, PreUpdateEventArgs $event): void
    {
        if ($event->hasChangedField('password')) {
            $encodedPassword = $this->encodePassword($account);
            $event->setNewValue('password', $encodedPassword);
        }
    }

    private function encodePassword(Account $account): string
    {
        return $this->passwordEncoder->encodePassword(
            SystemUser::fromAccount($account),
            $account->getPassword(),
        );
    }
}
