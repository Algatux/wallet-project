<?php declare(strict_types=1);

namespace AppBundle\Event\Listener;

use AppBundle\Event\TransactionEvent;
use AppBundle\Service\Amqp\MessagePublisher;
use AppBundle\Service\Amqp\Model\AmqpJobPayload;
use AppBundle\Service\Amqp\Model\AmqpWorkerJob;
use AppBundle\Service\Telegram\TelegramNotifier;
use AppBundle\Service\Worker\TransactionNotificationWorker;
use Telegram\Bot\Api;

class TelegramNotificationListener
{
    private $publisher;

    public function __construct(MessagePublisher $publisher)
    {
        $this->publisher = $publisher;
    }

    public function onTransactionCreated(TransactionEvent $event)
    {
        $this
            ->publisher
            ->publish(
                new AmqpWorkerJob(
                    TransactionNotificationWorker::class,
                    ['transactionId' => $event->getTransaction()->getId()]
                )
            );
    }
}
