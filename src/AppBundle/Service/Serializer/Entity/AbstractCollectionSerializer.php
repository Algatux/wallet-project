<?php declare(strict_types=1);

namespace AppBundle\Service\Serializer\Entity;

use AppBundle\Service\Serializer\SerializerInterface;
use Doctrine\Common\Collections\Collection;

abstract class AbstractCollectionSerializer
{
    protected function serializeCollection(
        SerializerInterface $serializer,
        Collection $collection,
        int $serializeMode = SerializerInterface::SERIALIZE_ALL
    ): array
    {
        return array_map(
            function($object) use ($serializer, $serializeMode) {
                return $serializer->serialize($object, $serializeMode);
            },
            $collection->toArray()
        );
    }
}