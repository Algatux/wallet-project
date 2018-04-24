<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp\Model;

class AmqpWorkerJob extends AmqpJob
{
    private $workerFQCN;
    private $attempts;
    private $payload;
    private $executeAt;
    private $expiration;

    public function __construct(
        string $fqcn,
        array $payload,
        int $attempts = 0,
        \DateTime $executeAt = null,
        \DateTime $expiration = null
    ){
        parent::__construct($payload);
        $this->workerFQCN = $fqcn;
        $this->payload = $payload;
        $this->attempts = $attempts;
        $this->executeAt = $executeAt;
        $this->expiration = $expiration;
    }

    public function getWorkerFQCN(): string
    {
        return $this->workerFQCN;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getExecuteAt(): ?\DateTime
    {
        return $this->executeAt;
    }

    public function getExpiration(): ?\DateTime
    {
        return $this->expiration;
    }

    public function publish()
    {
        return array_merge(
            parent::publish(),
            [
                'workerFQCN' => $this->workerFQCN,
                'attempts' => $this->attempts,
                'executeAt' => $this->executeAt,
                'expiration' => $this->expiration,
            ]
        );
    }

    public static function buildFromReceivedMessageContents(
        object $message,
        object $properties = null,
        object $deliveryInfo = null
    ): AmqpJob
    {
        $job = new self(
            $message->workerFQCN,
            (array) $message->payload,
            $message->attempts,
            $message->executeAt,
            $message->expiration
        );
        $job->setId($message->id);
        $job->setProperties($properties);
        $job->setDeliveryInfo($deliveryInfo);

        return $job;
    }
}
