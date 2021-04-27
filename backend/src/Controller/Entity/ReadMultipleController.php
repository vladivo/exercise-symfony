<?php

declare(strict_types=1);

namespace App\Controller\Entity;

use App\Controller\ControllerBase;
use App\Model\Permission\EntityAction;
use Doctrine\Common\Collections\Collection;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOS;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

final class ReadMultipleController extends ControllerBase
{
    /**
     * @FOS\View(serializerEnableMaxDepthChecks=true)
     */
    #[Route(path: '/entity/{type}', name: 'entity_get_multiple', methods: ['GET'], format: 'json')]
    #[IsGranted(EntityAction::READ, subject: 'type')]
    public function __invoke(Collection $entities): View
    {
        return $this->view($entities);
    }
}
