<?php declare(strict_types=1);

namespace AppBundle\Service\Serializer\Entity;

use AppBundle\Entity\Transaction;
use AppBundle\Service\Serializer\EntitySerializerInterface;
use AppBundle\Service\Serializer\SerializerInterface;

class TransactionSerializer extends AbstractCollectionSerializer implements EntitySerializerInterface
{
    public function canHandle(object $entity): bool
    {
        return $entity instanceof Transaction;
    }

    public function serialize(SerializerInterface $serializer, object $transaction, int $serializeMode): array
    {
        /** @var Transaction $transaction */

        if (SerializerInterface::SERIALIZE_RELATIONS_ID == $serializeMode) {
            return ['id' => $transaction->getId()];
        }

        return [
            'id' => $transaction->getId(),
            'motivation' => $transaction->getMotivation(),
            'amount' => $transaction->getAmount(),
            'floatAmount' => $transaction->getFloatAmount(),
            'type' => $transaction->getReadableType(),
            'transactedBy' => $serializer->serialize($transaction->getTransactedBy(), $serializeMode),
            'hasAttachment' => !empty($transaction->getFileName()),
        ];
    }
}