<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp\Model;

abstract class AmqpJob implements \JsonSerializable
{
    const ROUTING_KEY_DEFAULT = '';

    /** @var string */
    private $id;
    /** @var array */
    private $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function jsonSerialize()
    {
        return [
            'payload' => $this->payload
        ];
    }
}
