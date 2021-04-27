<?php

declare(strict_types=1);

namespace App\Model\User;

use App\Entity\User\Account;
use Symfony\Component\Security\Core\User\UserInterface;

interface User extends UserInterface
{
    public function getAccount(): Account;

    public function getEmail(): ?string;

    /**
     * @return array<int, string>
     */
    public function getPermissions(): array;

    public function hasPermission(string $permission): bool;
}
