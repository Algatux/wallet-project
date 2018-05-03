<?php declare(strict_types=1);

namespace AppBundle\Service\Serializer;

interface SerializerInterface
{
    const SERIALIZE_ALL = 1;
    const SERIALIZE_RELATIONS_ID = 2;

    public function serialize(object $object, int $serializeMode = self::SERIALIZE_ALL): array;
}
