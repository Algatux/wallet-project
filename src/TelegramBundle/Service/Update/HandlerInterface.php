<?php declare(strict_types=1);

namespace TelegramBundle\Service\Update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TelegramBundle\Model\Update;

/**
 * Interface HandlerInterface
 */
interface HandlerInterface
{
    public function handle(Request $request, JsonResponse $response, Update $update): bool;

    public function setPriority(int $priority);

    public function getPriority(): int;
}
