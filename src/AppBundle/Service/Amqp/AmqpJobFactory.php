<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp;

use AppBundle\Service\Amqp\Model\AmqpWorkerJob;

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

    public static function buildFromMessage(string $rawMessage): AmqpWorkerJob
    {
        $message = self::decodeMessage($rawMessage);

        switch($message->type) {
            case AmqpWorkerJob::class:
                return self::buildWorkerJob($message->body, $message->properties, $message->delivery_info);
            default :
                throw new \InvalidArgumentException('Unknown job type encountered');
        }
    }

    private static function buildWorkerJob(string $message, array $properties=[], array $deliveryInfo=[]): AmqpWorkerJob
    {
        $message = self::decodeMessage($message);
        $job = new AmqpWorkerJob($message->workerFQCN, (array) $message->payload);
        $job->setId($message->id);
        $job->setProperties($properties);
        $job->setDeliveryInfo($deliveryInfo);

        return $job;
    }
}