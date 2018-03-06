<?php declare(strict_types=1);

namespace App\Service\Update\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Telegram\Bot\Api;
use TelegramBundle\Model\Update;

class ChatHandler extends AbstractHandler
{
    /** @var Api */
    private $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handle(Request $request, JsonResponse $response, Update $update): bool
    {
        $text = sprintf(
            "Mi dispiace %s, non sono riuscito a capire quello che mi hai scritto",
            $update->getData()->message->from->first_name
        );

        $response->setData([
            'method' => 'sendMessage',
            'chat_id' => $update->getData()->message->chat->id,
            'text' => $text,
        ]);
        $response->setStatusCode(200);

        return false;
    }
}