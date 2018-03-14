<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp;

use AppBundle\Service\Amqp\Model\AmqpJob;

class AmqpJobFactory
{
    public static function decodeMessage(string $encodedMessage): object
    {
        /** @var object $message */
        $message = json_decode($encodedMessage);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException('Malformed json encountered');
        }

        return $message;
    }

    public static function buildFromMessage(string $rawMessage): AmqpJob
    {
        $msg = self::decodeMessage($rawMessage);
        $msgBody = self::decodeMessage($msg->body ?? '');

        if ($msgBody->type ?? false && is_subclass_of($msgBody->type, AmqpJob::class)) {
            return $msgBody->type::buildFromReceivedMessageContents(
                $msgBody,
                $msg->properties ?? null,
                $msg->delivery_info ?? null
            );
        }

        throw new \InvalidArgumentException('Unknown job type encountered');
    }
}