<?php

declare(strict_types=1);

namespace AppBundle\Service\Transaction;

use AppBundle\Entity\Transaction;
use AppBundle\Entity\Wallet;
use AppBundle\Event\TransactionEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class TransactionPersister.
 */
class TransactionPersister
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /**
     * WalletPersister constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Transaction $transaction
     * @param Wallet      $wallet
     */
    public function persistOnWallet(Transaction $transaction, Wallet $wallet)
    {
        $transaction->setWallet($wallet);

        $this->entityManager->persist($transaction);
        $this->entityManager->flush($transaction);

        $this->eventDispatcher->dispatch(TransactionEvent::EVENT_CREATED, new TransactionEvent($transaction));
    }

    /**
     * @param Transaction $transaction
     */
    public function delete(Transaction $transaction)
    {
        $this->entityManager->remove($transaction);
        $this->entityManager->flush($transaction);

        $this->eventDispatcher->dispatch(TransactionEvent::EVENT_DELETED, new TransactionEvent($transaction));
    }
}