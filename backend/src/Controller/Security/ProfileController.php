<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Controller\ControllerBase;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;

final class ProfileController extends ControllerBase
{
    #[Route(path: '/user/profile', name: 'user_profile', methods: ['get'], format: 'json')]
    public function __invoke(): View
    {
        return $this->view($this->getUser());
    }
}
