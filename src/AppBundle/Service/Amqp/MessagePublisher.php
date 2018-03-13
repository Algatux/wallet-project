<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp;

use AppBundle\Service\Amqp\Model\AmqpJob;
use PhpAmqpLib\Connection\AMQPStreamConnection;

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
    }
}