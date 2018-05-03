<?php declare(strict_types=1);

namespace AppBundle\Service\Serializer;

use AppBundle\Service\Serializer\Entity\TransactionSerializer;
use AppBundle\Service\Serializer\Entity\UserSerializer;
use AppBundle\Service\Serializer\Entity\WalletSerializer;

class ApiSerializer implements SerializerInterface
{
    /** @var EntitySerializerInterface[] */
    private $serializers;

    public function __construct()
    {
        $this->serializers = [
            new UserSerializer(),
            new WalletSerializer(),
            new TransactionSerializer(),
        ];
    }

    public function serialize(object $object, int $serializeMode = self::SERIALIZE_ALL): array
    {
        return array_reduce(
            $this->serializers,
            function (array $result, EntitySerializerInterface $serializer) use ($object, $serializeMode) {

                if ($serializer->canHandle($object)) {
                    return $serializer->serialize($this, $object, $serializeMode);
                }

                return $result;
            },
            []
        );
    }
}