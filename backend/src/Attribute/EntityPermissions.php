<?php

declare(strict_types=1);

namespace App\Attribute;

use App\Model\Permission\EntityAction;
use Attribute;
use function in_array;

#[Attribute(Attribute::TARGET_CLASS)]
final class EntityPermissions
{
    /**
     * @var array<int, string>
     */
    private array $categories;

    public function __construct(array $categories = [EntityAction::CATEGORY_DEFAULT])
    {
        if (!in_array(EntityAction::CATEGORY_DEFAULT, $categories, true)) {
            $categories[] = EntityAction::CATEGORY_DEFAULT;
        }

        $this->categories = $categories;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }
}
