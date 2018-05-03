<?php declare(strict_types=1);

namespace AppBundle\Service\Serializer\Entity;

use AppBundle\Entity\Wallet;
use AppBundle\Service\Serializer\EntitySerializerInterface;
use AppBundle\Service\Serializer\SerializerInterface;

class WalletSerializer extends AbstractCollectionSerializer implements EntitySerializerInterface
{
    public function canHandle(object $entity): bool
    {
        return $entity instanceof Wallet;
    }

    public function serialize(SerializerInterface $serializer, object $wallet, int $serializeMode): array
    {
        /** @var Wallet $wallet */
        return [
            'id' => $wallet->getId(),
            'name' => $wallet->getName(),
            'description' => $wallet->getDescription(),
            'settled' => $wallet->isSettled(),

            'transactions' => $this->serializeCollection($serializer, $wallet->getTransactions(), $serializeMode),
            'owner' => $serializer->serialize($wallet->getOwner(), $serializeMode),
            'sharedWith' => $this->serializeCollection($serializer, $wallet->getSharedWith(), $serializeMode),
        ];
    }
}