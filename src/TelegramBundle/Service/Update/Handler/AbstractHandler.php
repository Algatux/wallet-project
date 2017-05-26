<?php declare(strict_types=1);

namespace TelegramBundle\Service\Update\Handler;

use TelegramBundle\Service\Update\HandlerInterface;

/**
 * Class AbstractHandler.
 */
abstract class AbstractHandler implements HandlerInterface
{
    /** @var int */
    private $priority;

    public function setPriority(int $priority)
    {
        $this->priority = $priority;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }
}
