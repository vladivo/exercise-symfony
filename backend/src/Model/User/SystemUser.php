<?php

declare(strict_types=1);

namespace App\Model\User;

use App\Entity\User\Account;
use App\Entity\User\Permission;
use App\Entity\User\Role;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;
use function assert;
use function sprintf;
use function strtoupper;

final class SystemUser implements User
{
    /**
     * @Serializer\Exclude
     */
    private Account $account;

    /**
     * @Serializer\Exclude
     * @var Collection<string>|null
     */
    private ?Collection $roles = null;

    /**
     * @Serializer\Exclude
     * @var Collection<string>|null
     */
    private ?Collection $permissions = null;

    public static function fromAccount(Account $account): self
    {
        $user = new self();
        $user->account = $account;

        return $user;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @Serializer\VirtualProperty
     */
    public function getUsername(): ?string
    {
        return $this->account->getName();
    }

    /**
     * @Serializer\VirtualProperty
     */
    public function getEmail(): ?string
    {
        return $this->account->getMail();
    }

    /**
     * @Serializer\VirtualProperty
     * @return array<int, string>
     */
    public function getRoles(): array
    {
        if ($this->roles === null) {
            $this->initRoles();
        }

        return $this->roles->toArray();
    }

    /**
     * @Serializer\VirtualProperty
     *
     * @return array<int, string>
     */
    public function getPermissions(): array
    {
        if ($this->permissions === null) {
            $this->initPermissions();
        }

        return $this->permissions->toArray();
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->permissions === null) {
            $this->initPermissions();
        }

        return $this->permissions->contains($permission);
    }

    public function getPassword(): ?string
    {
        return $this->account->getPassword();
    }

    public function getSalt(): void
    {
    }

    public function eraseCredentials(): void
    {
    }

    private function initRoles(): void
    {
        $this->roles = $this->account
            ->getRoles()
            ->map(fn(Role $role) => sprintf('ROLE_%s', strtoupper($role->getName())));
    }

    private function initPermissions(): void
    {
        $permissions = [];
        foreach ($this->account->getRoles() as $role) {
            assert($role instanceof Role);
            foreach ($role->getPermissions() as $permission) {
                assert($permission instanceof Permission);
                $permissions[] = $permission->getName();
            }
        }

        $this->permissions = new ArrayCollection($permissions);
    }
}
