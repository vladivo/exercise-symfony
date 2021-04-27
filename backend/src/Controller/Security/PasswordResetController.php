<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Controller\ControllerBase;
use App\Entity\User\Account;
use App\Mail\Security\MailFactory;
use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use function sprintf;

final class PasswordResetController extends ControllerBase
{
    #[Route(path: '/user/password/reset', name: 'user_password_reset', methods: ['POST'], format: 'json')]
    public function __invoke(
        ?Account $requestedAccount,
        ResetPasswordHelperInterface $resetPasswordHelper,
        MailFactory $mailFactory,
        MailerInterface $mailer,
        LoggerInterface $logger,
    ): View {
        $view = $this->view(null, Response::HTTP_NO_CONTENT);

        if ($requestedAccount === null) {
            $logger->warning('Reset password request error');

            return $view;
        }

        try {
            $token = $resetPasswordHelper->generateResetToken($requestedAccount);
        } catch (ResetPasswordExceptionInterface $e) {
            $logger->warning(sprintf('User %s: %s', $requestedAccount->getName(), $e->getReason()));

            return $view;
        }

        $link = $this->generateUrl(
            'user_login_onetime',
            ['token' => $token->getToken()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $mail = $mailFactory->createOneTimeLoginMail($requestedAccount, $link);
        $mailer->send($mail);

        $logger->warning(sprintf('User %s: reset password request', $requestedAccount->getName()));

        return $view;
    }
}
