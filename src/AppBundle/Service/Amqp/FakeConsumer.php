<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class FakeConsumer implements ConsumerInterface
{
    /**
     * @param AMQPMessage $msg The message
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        dump($msg);
    }
}