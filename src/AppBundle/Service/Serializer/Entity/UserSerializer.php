<?php declare(strict_types=1);

namespace AppBundle\Service\Serializer\Entity;

use AppBundle\Entity\User;
use AppBundle\Entity\Wallet;
use AppBundle\Service\Serializer\EntitySerializerInterface;
use AppBundle\Service\Serializer\SerializerInterface;

class UserSerializer extends AbstractCollectionSerializer implements EntitySerializerInterface
{
    public function canHandle(object $entity): bool
    {
        return $entity instanceof User;
    }

    public function serialize(SerializerInterface $serializer, object $user, int $serializeMode): array
    {
        /** @var User $user */

        if (SerializerInterface::SERIALIZE_RELATIONS_ID == $serializeMode) {
            return ['id' => $user->getId()];
        }

        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'nickname' => $user->getNickName(),
            'name' => $user->getFirstName(),
            'surname' => $user->getLastName(),
            'email' => $user->getEmail()
        ];
    }
}