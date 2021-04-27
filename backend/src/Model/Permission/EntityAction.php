<?php

declare(strict_types=1);

namespace App\Model\Permission;

final class EntityAction
{
    public const CATEGORY_DEFAULT = 'default';
    public const CATEGORY_AUTHORED = 'authored';

    public const CREATE = 'create';
    public const READ = 'read';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
    public const READ_OWN = 'read_own';
    public const UPDATE_OWN = 'update_own';
    public const DELETE_OWN = 'delete_own';

    private static ?array $categories = null;

    private static function initCategories(): void
    {
        self::$categories = [
            self::CATEGORY_DEFAULT => [
                self::CREATE,
                self::READ,
                self::UPDATE,
                self::DELETE,
            ],
            self::CATEGORY_AUTHORED => [
                self::READ_OWN,
                self::UPDATE_OWN,
                self::DELETE_OWN,
            ],
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function getCategory(string $category): array
    {
        if (self::$categories === null) {
            self::initCategories();
        }

        return self::$categories[$category];
    }
}
