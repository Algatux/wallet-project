<?php declare(strict_types=1);

namespace AppBundle\Service\Telegram;

use AppBundle\Entity\Transaction;
use Telegram\Bot\Api as TelegramClient;
use Telegram\Bot\Objects\Message;

class TelegramNotifier
{
    /** @var TelegramClient */
    private $telegramClient;
    /** @var int */
    private $groupId;

    public function __construct(TelegramClient $telegramClient, int $groupId)
    {
        $this->telegramClient = $telegramClient;
        $this->groupId = (int) $groupId;
    }

    public function notifyTransactionCreated(Transaction $transaction): Message
    {
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