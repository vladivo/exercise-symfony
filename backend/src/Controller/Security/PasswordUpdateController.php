<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Controller\ControllerBase;
use App\Exception\EntityValidationException;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class PasswordUpdateController extends ControllerBase
{
    #[Route(path: '/user/password/update', name: 'user_password_change', methods: ['POST'], format: 'json')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function __invoke(string $newPassword, ValidatorInterface $validator): View
    {
        $account = $this->getUser()->getAccount();
        $oldPassword = $account->getPassword();
        $account->setPassword($newPassword);

        $errors = $validator->validate($account);
        if ($errors->count() > 0) {
            $account->setPassword($oldPassword);

            throw new EntityValidationException($errors);
        }

        $objectManager = $this->getDoctrine()->getManager();
        $objectManager->flush();
        $objectManager->refresh($account);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
