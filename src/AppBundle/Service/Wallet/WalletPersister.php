<?php

declare(strict_types=1);

namespace AppBundle\Service\Wallet;

use AppBundle\Entity\Wallet;
use AppBundle\Event\WalletEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class WalletPersister.
 */
class WalletPersister
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
     * @param Wallet $wallet
     */
    public function persist(Wallet $wallet)
    {
        $this->entityManager->persist($wallet);
        $this->entityManager->flush([$wallet]);

        $this->eventDispatcher->dispatch(WalletEvent::EVENT_CREATED, new WalletEvent($wallet));
    }

    /**
     * @param Wallet $wallet
     */
    public function update(Wallet $wallet)
    {
        $this->entityManager->flush([$wallet]);

        $this->eventDispatcher->dispatch(WalletEvent::EVENT_UPDATED, new WalletEvent($wallet));
    }

    /**
     * @param Wallet $wallet
     */
    public function delete(Wallet $wallet)
    {
        $this->entityManager->remove($wallet);
        $this->entityManager->flush([$wallet]);

        $this->eventDispatcher->dispatch(WalletEvent::EVENT_DELETED, new WalletEvent($wallet));
    }
}
