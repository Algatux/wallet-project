<?php declare(strict_types=1);

namespace AppBundle\Event\Listener;

use AppBundle\Event\TransactionEvent;
use Telegram\Bot\Api;

/**
 * Class TransactionListener.
 */
class TransactionListener
{
    /** @var Api */
    private $telegramClient;
    /** @var int */
    private $groupId;

    /**
     * TransactionListener constructor.
     *
     * @param Api $telegramClient
     * @param int $groupId
     */
    public function __construct(Api $telegramClient, int $groupId)
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
        $text = sprintf(
            implode(PHP_EOL, $text),
            $transaction->getTransactedBy()->getNickName(),
            $transaction->getMotivation(),
            abs($transaction->getFloatAmount())
        );

        $this->telegramClient->sendMessage([
            'text' => $text,
            'chat_id' => $this->groupId,
            'parse_mode' => 'markdown'
        ]);


    }
}
