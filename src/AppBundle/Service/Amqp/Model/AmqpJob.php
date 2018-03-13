<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp\Model;

use Symfony\Component\Validator\Constraints\Uuid;

class AmqpJob implements \JsonSerializable
{
    const ROUTING_KEY_DEFAULT = '';

    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function jsonSerialize()
    {
        return [
            'payload' => $this->data
        ];
    }
}
