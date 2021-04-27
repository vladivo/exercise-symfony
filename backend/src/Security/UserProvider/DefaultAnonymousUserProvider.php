<?php

declare(strict_types=1);

namespace App\Security\UserProvider;

use App\Entity\User\Account;
use App\Entity\User\Role;
use App\Model\User\SystemUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class DefaultAnonymousUserProvider implements AnonymousUserProvider
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function getUser(): UserInterface
    {
        $role = $this->entityManager
            ->getRepository(Role::class)
            ->find(Role::ID_ANONYMOUS);

        $account = new Account();
        $account->setName('anonymous');
        $account->setMail('');
        $account->getRoles()->add($role);

        return SystemUser::fromAccount($account);
    }
}
