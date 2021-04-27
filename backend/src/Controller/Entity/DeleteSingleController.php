<?php

declare(strict_types=1);

namespace App\Controller\Entity;

use App\Controller\ControllerBase;
use App\Entity\Entity;
use App\Model\Permission\EntityAction;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteSingleController extends ControllerBase
{
    #[Route(path: '/entity/{type}/{id<\d+>}', name: 'entity_delete_single', methods: ['DELETE'], format: 'json')]
    #[IsGranted(EntityAction::DELETE, subject: 'entity')]
    public function __invoke(Entity $entity): View
    {
        $objectManager = $this->getDoctrine()->getManager();
        $objectManager->remove($entity);
        $objectManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
