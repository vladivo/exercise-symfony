<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Controller\ControllerBase;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class LoginController extends ControllerBase
{
    #[Route(path: '/user/login', name: 'user_login', methods: ['POST'], format: 'json')]
    public function __invoke(): View
    {
        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
