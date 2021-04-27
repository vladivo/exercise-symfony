<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Controller\ControllerBase;
use App\Entity\User\Account;
use App\Entity\User\Role;
use App\Exception\EntityValidationException;
use App\Form\Entity\EntityType;
use App\Mail\Security\MailFactory;
use App\Model\Form\FormInput;
use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use function sha1;
use function random_bytes;

final class RegisterController extends ControllerBase
{
    #[Route(path: '/user/register', name: 'user_register', methods: ['POST'], format: 'json')]
    public function __invoke(
        FormInput $formInput,
        ValidatorInterface $validator,
        ResetPasswordHelperInterface $resetPasswordHelper,
        MailFactory $mailFactory,
        MailerInterface $mailer,
        LoggerInterface $logger,
    ): View {
        $objectManager = $this->getDoctrine()->getManager();

        // Prepare Account
        $account = new Account();
        $account->setEnabled(true);
        $account->setInternal(false);
        $account->setPassword(sha1(random_bytes(8)));
        $account->getRoles()->add(
            $objectManager->getRepository(Role::class)->find(Role::ID_AUTHENTICATED),
        );

        // Submit form
        $form = $this->createForm(EntityType::class, $account);
        $form->submit($formInput->getData(), false);

        $errors = $validator->validate($form);
        if(count($errors) > 0) {
            throw new EntityValidationException($errors);
        }

        // Save account
        $objectManager->persist($account);
        $objectManager->flush();

        // Send password reset email
        $token = $resetPasswordHelper->generateResetToken($account);
        $link = $this->generateUrl(
            'user_login_onetime',
            ['token' => $token->getToken()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $mail = $mailFactory->createOneTimeLoginMail($account, $link);
        $mailer->send($mail);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
