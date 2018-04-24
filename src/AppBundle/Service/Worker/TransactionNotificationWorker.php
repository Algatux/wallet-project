<?php declare(strict_types=1);

namespace AppBundle\Service\Worker;

use AppBundle\Entity\Transaction;
use AppBundle\Service\Amqp\Model\AmqpWorkerJob;
use AppBundle\Service\Telegram\TelegramNotifier;
use Doctrine\ORM\EntityManagerInterface;

class TransactionNotificationWorker extends AbstractWorker
{
    private $notifier;
    private $entityManager;

    public function __construct(TelegramNotifier $notifier, EntityManagerInterface $entityManager)
    {
        $this->notifier = $notifier;
        $this->entityManager = $entityManager;
    }

    public function execute(AmqpWorkerJob $job)
    {
        $this
            ->notifier
            ->notifyTransactionCreated($this->retrieveSubject($job));
    }

    public function retrieveSubject(AmqpWorkerJob $job): Transaction
    {
        return $this
            ->entityManager
            ->find(Transaction::class, $job->getPayload()['transactionId']);
    }
}
