<?php declare(strict_types=1);

namespace AppBundle\Service\Worker;

use AppBundle\Service\Amqp\Model\AmqpWorkerJob;
use Telegram\Bot\Api;

class TransactionNotificationWorker extends AbstractWorker
{
    /** @var Api */
    private $telegramClient;
    /** @var int */
    private $groupId;

    public function __construct(Api $telegramClient, int $groupId)
    {
        $this->telegramClient = $telegramClient;
        $this->groupId = $groupId;
    }

    public function execute(AmqpWorkerJob $job)
    {
        dump($job);

        sleep(30);
//        $transaction = $event->getTransaction();
//
//        $text = [
//            "*Nuova transazione*",
//            "*utente*: %s",
//            "*motivazione*: %s",
//            "*spesa*: %.2f€",
//        ];
//        $text = sprintf(
//            implode(PHP_EOL, $text),
//            $transaction->getTransactedBy()->getNickName(),
//            $transaction->getMotivation(),
//            abs($transaction->getFloatAmount())
//        );
//
//        $this->telegramClient->sendMessage([
//            'text' => $text,
//            'chat_id' => $this->groupId,
//            'parse_mode' => 'markdown'
//        ]);
    }

//    public function retrieveSubject()
//    {
//
//    }
}