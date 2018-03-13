<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp;

use AppBundle\Service\Amqp\Model\AmqpJob;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessagePublisher
{
    /** @var string */
    private $host;
    /** @var string */
    private $user;
    /** @var string */
    private $password;
    /** @var string */
    private $vHost;
    /** @var string */
    private $exchange;
    /**
     * @var int
     */
    private $port;

    public function __construct(string $host, int $port, string $user, string $password, string $vHost, string $exchange)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->vHost = $vHost;
        $this->exchange = $exchange;
    }

    public function publish(AmqpJob $job, string $routingKey = AmqpJob::ROUTING_KEY_DEFAULT)
    {
        $conn = new AMQPStreamConnection(
            $this->host,
            $this->port,
            $this->user,
            $this->password,
            $this->vHost
        );

        $payload = array_merge(['id' => uniqid()], $job->getData());
        $message = new AMQPMessage(
            json_encode($payload),
            [
                'content_type' => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );

        $channel = $conn->channel();
        $channel->exchange_declare($this->exchange, 'direct', true, true, false);
        $channel->basic_publish($message, $this->exchange, $routingKey);

        $conn->close();
    }
}