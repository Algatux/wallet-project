<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Wallet;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class WalletEvent
 */
class WalletEvent extends Event
{
    const EVENT_CREATED = 'event.wallet.created';
    const EVENT_UPDATED = 'event.wallet.updated';
    const EVENT_DELETED = 'event.wallet.deleted';

    /** @var Wallet */
    private $wallet;

    /**
     * WalletEvent constructor.
     *
     * @param Wallet $wallet
     */
    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * @return Wallet
     */
    public function getWallet(): Wallet
    {
        return $this->wallet;
    }
}
