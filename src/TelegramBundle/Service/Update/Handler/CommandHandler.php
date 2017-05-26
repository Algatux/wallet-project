<?php declare(strict_types=1);

namespace TelegramBundle\Service\Update\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TelegramBundle\Model\Update;

/**
 * Class CommandHandler.
 */
class CommandHandler extends AbstractHandler
{
    public function handle(Request $request, JsonResponse $response, Update $update): bool
    {
        return true;
    }
}
