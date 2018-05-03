<?php declare(strict_types=1);

namespace AppBundle\Service\Serializer;

interface EntitySerializerInterface
{
    public function canHandle(object $entity): bool;

    public function serialize(SerializerInterface $serializer, object $entity, int $serializeMode): array;
}
