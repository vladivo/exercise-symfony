<?php

declare(strict_types=1);

namespace App\Security\UserProvider;

use App\Entity\User\Account;
use App\Model\User\SystemUser;
use App\Model\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use function assert;
use function is_subclass_of;

final class AuthenticatedUserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function loadUserByUsername(string $username): UserInterface
    {
        $account = $this->getAccountRepository()->findOneBy(['name' => $username, 'enabled' => true]);

        if ($account === null) {
            throw new UsernameNotFoundException();
        }

        assert($account instanceof Account);

        return SystemUser::fromAccount($account);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException();
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass(string $class): bool
    {
        return is_subclass_of($class, User::class);
    }

    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        assert($user instanceof User);

        $account = $user->getAccount();
        $account->setPassword($newEncodedPassword);

        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }

    private function getAccountRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Account::class);
    }
}
