<?php declare(strict_types=1);

namespace AppBundle\Service\Telegram;

use unreal4u\TelegramAPI\Abstracts\TelegramTypes;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\TgLog;

/**
 * Class TelegramClient.
 */
class TelegramClient
{
    /** @var TgLog */
    private $tgLog;

    /**
     * TelegramClient constructor.
     *
     * @param TgLog $tgLog
     */
    public function __construct(TgLog $tgLog)
    {
        $this->tgLog = $tgLog;
    }

    /**
     * @param string $message
     * @param int $groupId
     * @param string $parseMode
     *
     * @return TelegramTypes
     */
    public function sendSimpleMessage(string $message, int $groupId, string $parseMode = 'markdown'): TelegramTypes
    {
        $send = new SendMessage();
        $send->chat_id = $groupId;
        $send->text = $message;
        $send->parse_mode = $parseMode;

        return $this->tgLog->performApiRequest($send);
    }
}
