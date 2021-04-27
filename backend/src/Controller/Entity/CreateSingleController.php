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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateSingleController extends ControllerBase
{
    #[Route(path: '/entity/{type}', name: 'entity_create_single', methods: ['POST'], format: 'json')]
    #[IsGranted(EntityAction::CREATE, subject: 'newEntity')]
    public function __invoke(Entity $newEntity, FormInput $formInput, ValidatorInterface $validator): View
    {
        $form = $this->createForm(EntityType::class, $newEntity);
        $form->submit($formInput->getData());

        $errors = $validator->validate($form);
        if(count($errors) > 0) {
            throw new EntityValidationException($errors);
        }

        $objectManager = $this->getDoctrine()->getManager();
        $objectManager->persist($newEntity);
        $objectManager->flush();
        $objectManager->refresh($newEntity);

        return $this->routeRedirectView(
            'entity_get_single',
            [
                'type' => $newEntity->getType(),
                'id' => $newEntity->getId(),
            ],
        );
    }
}
