<?php declare(strict_types=1);

namespace App\Service\Update\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Telegram\Bot\Api;
use TelegramBundle\Model\Update;
use TelegramBundle\Service\Update\Command\PippoCommand;

/**
 * Class CommandHandler.
 */
class CommandHandler extends AbstractHandler
{
    /** @var Api */
    private $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handle(Request $request, JsonResponse $response, Update $update): bool
    {

        $this->telegram->addCommand(new PippoCommand());
        $this->telegram->commandsHandler(true);

        return true;
    }
}
