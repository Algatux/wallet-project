<?php declare(strict_types=1);

namespace AppBundle\Event\Listener;

use AppBundle\Event\TransactionEvent;
use AppBundle\Service\Telegram\TelegramClient;

/**
 * Class TransactionListener.
 */
class TransactionListener
{
    /** @var TelegramClient */
    private $telegramClient;
    /** @var int */
    private $groupId;

    /**
     * TransactionListener constructor.
     *
     * @param TelegramClient $telegramClient
     * @param int            $groupId
     */
    public function __construct(TelegramClient $telegramClient, int $groupId)
    {
        $this->telegramClient = $telegramClient;
        $this->groupId = (int) $groupId;
    }

    /**
     * @param TransactionEvent $event
     */
    public function onTransactionCreated(TransactionEvent $event)
    {
        $transaction = $event->getTransaction();

        $text = [
            "*Nuova transazione*",
            "*utente*: %s",
            "*motivazione*: %s",
            "*spesa*: %.2f€",
        ];

        $this->telegramClient->sendSimpleMessage(
            sprintf(
                implode(PHP_EOL, $text),
                $transaction->getTransactedBy()->getNickName(),
                $transaction->getMotivation(),
                abs($transaction->getFloatAmount())
            ),
            $this->groupId
        );
    }
}
