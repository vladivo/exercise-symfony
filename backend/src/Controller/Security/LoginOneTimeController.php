<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Controller\ControllerBase;
use App\Entity\User\Account;
use App\Model\User\SystemUser;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use function assert;
use function serialize;

final class LoginOneTimeController extends ControllerBase
{
    #[Route(path: '/user/login/onetime/{token}', name: 'user_login_onetime', methods: ['POST'], format: 'json')]
    public function __invoke(
        string $token,
        ResetPasswordHelperInterface $resetPasswordHelper,
        TokenStorageInterface $tokenStorage,
        Session $session,
    ): View {
        $account = $resetPasswordHelper->validateTokenAndFetchUser($token);
        assert($account instanceof Account);

        $resetPasswordHelper->removeResetRequest($token);

        $user = SystemUser::fromAccount($account);
        $userToken = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($userToken));

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
