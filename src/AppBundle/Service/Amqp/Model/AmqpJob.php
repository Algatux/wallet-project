<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp\Model;

abstract class AmqpJob
{
    const ROUTING_KEY_DEFAULT = '';

    /** @var string */
    private $id;
    /** @var array */
    private $payload;
    /** @var object */
    private $deliveryInfo;
    /** @var object */
    private $properties;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
        $this->deliveryInfo;
        $this->properties;
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

    public function getProperties(): ?object
    {
        return $this->properties;
    }

    public function setProperties(object $properties=null)
    {
        $this->properties = $properties;
    }

    public function getDeliveryInfo(): ?object
    {
        return $this->deliveryInfo;
    }

    public function setDeliveryInfo(object $deliveryInfo=null)
    {
        $this->deliveryInfo = $deliveryInfo;
    }

    public function publish()
    {
        return [
            'payload' => $this->payload
        ];
    }

    public static abstract function buildFromReceivedMessageContents(
        object $message,
        object $properties = null,
        object $deliveryInfo = null
    ): AmqpJob;
}
