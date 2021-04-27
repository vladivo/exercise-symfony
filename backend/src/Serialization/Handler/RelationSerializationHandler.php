<?php

declare(strict_types=1);

namespace App\Serialization\Handler;

use App\Entity\Entity;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;

final class RelationSerializationHandler implements SubscribingHandlerInterface
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'Relation',
                'method' => 'serializeRelation',
            ],
        ];
    }

    public function serializeRelation(JsonSerializationVisitor $visitor, Entity $relation, array $type, Context $context): int
    {
        return $relation->getId();
    }
}
