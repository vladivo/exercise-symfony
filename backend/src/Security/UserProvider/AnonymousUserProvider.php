<?php

declare(strict_types=1);

namespace App\Security\UserProvider;

use Symfony\Component\Security\Core\User\UserInterface;

interface AnonymousUserProvider
{
    public function getUser(): UserInterface;
}
