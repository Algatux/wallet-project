<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp\Model;

class AmqpWorkerJob extends AmqpJob
{
    /** @var string */
    private $workerFQCN;

    public function __construct(string $fqcn, array $payload)
    {
        parent::__construct($payload);
        $this->workerFQCN = $fqcn;
    }

    public function getWorkerFQCN(): string
    {
        return $this->workerFQCN;
    }

    public function publish()
    {
        return array_merge(parent::publish(), ["workerFQCN" => $this->workerFQCN]);
    }

    public static function buildFromReceivedMessageContents(
        object $message,
        object $properties = null,
        object $deliveryInfo = null
    ): AmqpJob
    {
        $job = new self($message->workerFQCN, (array) $message->payload);
        $job->setId($message->id);
        $job->setProperties($properties);
        $job->setDeliveryInfo($deliveryInfo);

        return $job;
    }
}
