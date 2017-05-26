<?php declare(strict_types=1);

namespace TelegramBundle\Service\Update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TelegramBundle\Model\Update;

/**
 * Class Handler.
 */
class Handler
{
    /** @var \SplPriorityQueue */
    private $handlers;

    public function __construct()
    {
        $this->handlers = new \SplPriorityQueue();
    }

    public function addHandler(HandlerInterface $handler)
    {
        $this->handlers->insert($handler, $handler->getPriority());
    }

    public function handle(Request $request): JsonResponse
    {
        $reponse = new JsonResponse();
        $update = new Update();

        /** @var HandlerInterface $handler */
        foreach ($this->handlers as $handler) {
            if (false === $handler->handle($request, $reponse, $update)) {
                break;
            }
        }

        return $reponse;
    }
}
