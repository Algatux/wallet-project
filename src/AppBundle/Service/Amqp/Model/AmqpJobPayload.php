<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp\Model;

class AmqpJobPayload implements \JsonSerializable
{
    private $data;
    private $attempts;
    private $nextExecution;

    public function __construct(array $data, int $attempts = 0, \DateTimeImmutable $nextExecution = null)
    {
        $this->data = $data;
        $this->attempts = $attempts;
        $this->nextExecution = $nextExecution;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function getNextExecution(): \DateTimeImmutable
    {
        return $this->nextExecution;
    }

    public function jsonSerialize()
    {
        return [
            'data' => $this->data,
            'attempts' => $this->attempts,
            'nextExecution' => $this->nextExecution
        ];
    }
}