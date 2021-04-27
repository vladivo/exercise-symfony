<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Attribute\EntityPermissions;
use App\Repository\User\PermissionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PermissionRepository::class)
 */
#[EntityPermissions]
final class Permission extends UserEntityBase
{
}
