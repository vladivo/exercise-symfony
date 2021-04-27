<?php

declare(strict_types=1);

namespace App\Controller\Entity;

use App\Controller\ControllerBase;
use App\Entity\Entity;
use App\Model\Permission\EntityAction;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

final class ReadSingleController extends ControllerBase
{
    /**
     * @FOS\View(serializerEnableMaxDepthChecks=true)
     */
    #[Route(path: '/entity/{type}/{id<\d+>}', name: 'entity_get_single', methods: ['GET'], format: 'json')]
    #[IsGranted(EntityAction::READ, subject: 'entity')]
    public function __invoke(Entity $entity): View
    {
        return $this->view($entity);
    }
}
