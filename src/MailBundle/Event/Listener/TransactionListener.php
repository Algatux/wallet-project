<?php

declare(strict_types = 1);

namespace MailBundle\Event\Listener;

use AppBundle\Event\TransactionEvent;
use Doctrine\ORM\EntityManagerInterface;
use MailBundle\Mailer\TransactionMailer;

/**
 * Class TransactionListener
 */
class TransactionListener
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TransactionMailer */
    private $transactionMailer;

    /**
     * TransactionListener constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param TransactionMailer      $transactionMailer
     */
    public function __construct(EntityManagerInterface $entityManager, TransactionMailer $transactionMailer)
    {
        $this->entityManager = $entityManager;
        $this->transactionMailer = $transactionMailer;
    }

    /**
     * @param TransactionEvent $event
     */
    public function onTransactionCreated(TransactionEvent $event)
    {
        $this->transactionMailer->notifyTransactionCreated($event->getTransaction());
    }
}
