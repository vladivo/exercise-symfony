<?php

declare(strict_types=1);

namespace App\Controller\Entity;

use App\Controller\ControllerBase;
use App\Entity\Entity;
use App\Exception\EntityValidationException;
use App\Form\Entity\EntityType;
use App\Model\Form\FormInput;
use App\Model\Permission\EntityAction;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UpdateSingleController extends ControllerBase
{
    #[Route(path: '/entity/{type}/{id<\d+>}', name: 'entity_update_single', methods: ['PATCH'], format: 'json')]
    #[IsGranted(EntityAction::UPDATE, subject: 'entity')]
    public function __invoke(Entity $entity, FormInput $formInput, ValidatorInterface $validator): View
    {
        $form = $this->createForm(EntityType::class, $entity);
        $form->submit($formInput->getData(), false);

        $errors = $validator->validate($form);
        if(count($errors) > 0) {
            throw new EntityValidationException($errors);
        }

        $objectManager = $this->getDoctrine()->getManager();
        $objectManager->flush();
        $objectManager->refresh($entity);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
