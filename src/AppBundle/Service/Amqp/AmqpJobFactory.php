<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp;

use AppBundle\Service\Amqp\Model\AmqpWorkerJob;

class AmqpJobFactory
{
    public static function buildFromMessage(string $rawMessage): AmqpWorkerJob
    {
        $message = json_decode($rawMessage);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException('Malformed json encountered');
        }

        switch($message->type) {
            case AmqpWorkerJob::class:
                return self::buildWorkerJob($message);
            default :
                throw new \InvalidArgumentException('Unknown job type encountered');
        }
    }

    private static function buildWorkerJob($message): AmqpWorkerJob
    {
        $job = new AmqpWorkerJob($message->workerFQCN, (array) $message->payload);
        $job->setId($message->id);

        return $job;
    }
}