<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqWorkerConsumer implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {

    }
}
