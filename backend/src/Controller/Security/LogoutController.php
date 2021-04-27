<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Controller\ControllerBase;
use FOS\RestBundle\View\View;
use LogicException;
use Symfony\Component\Routing\Annotation\Route;

final class LogoutController extends ControllerBase
{
    #[Route(path: '/user/logout', name: 'user_logout', methods: ['POST'], format: 'json')]
    public function __invoke(): View
    {
        throw new LogicException('This code should never be reached');
    }
}
