<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp\Model;

class AmqpJob
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
}