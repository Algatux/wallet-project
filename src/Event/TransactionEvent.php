<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Transaction;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class TransactionEvent.
 */
class TransactionEvent extends Event
{
    const EVENT_CREATED = 'event.transaction.created';
    const EVENT_REFUND = 'event.transaction.refund';
    const EVENT_DELETED = 'event.transaction.deleted';

    /** @var Transaction */
    private $transaction;

    /**
     * TransactionEvent constructor.
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return Transaction
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    /**
     * @param Transaction $transaction
     */
    public function setTransaction(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
