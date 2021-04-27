<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;

abstract class ControllerBase extends AbstractFOSRestController
{
    protected function getUser(): User
    {
        $user = parent::getUser();
        assert($user instanceof User);

        return $user;
    }
}
