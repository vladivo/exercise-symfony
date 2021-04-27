<?php

declare(strict_types=1);

namespace App\Utils\Entity\TypeMapper;

use App\Entity\Entity;
use function is_subclass_of;
use function str_replace;
use function strtolower;
use function ucwords;

final class DefaultTypeMapper implements ClassToTypeMapper, TypeToClassMapper
{
    public function getType(string $className): ?string
    {
        return self::mapClassToType($className);
    }

    public function getClass(string $type): ?string
    {
        return self::mapTypeToClass($type);
    }

    public static function mapTypeToClass(string $type): ?string
    {
        $className = self::formatClassName($type);

        return self::isEntityClass($className) ? $className : null;
    }

    public static function mapClassToType(string $className): ?string
    {
        return self::isEntityClass($className) ? self::formatType($className) : null;
    }

    private static function formatType(string $className): string
    {
        return strtolower(str_replace('\\', '_', $className));
    }

    private static function formatClassName(string $type): string
    {
        return str_replace('_', '\\', ucwords($type, '_'));
    }

    private static function isEntityClass(string $className): bool
    {
        return is_subclass_of($className, Entity::class);
    }
}
