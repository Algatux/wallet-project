<?php declare(strict_types=1);

namespace TelegramBundle\Service\Update\Handler;

use MongoDB\BSON\UTCDateTime;
use MongoDB\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TelegramBundle\Model\Update;
use TelegramBundle\Service\Update\HandlerInterface;

/**
 * Class LogHandler.
 */
class LogHandler extends AbstractHandler implements HandlerInterface
{
    /** @var Collection */
    private $collection;

    /**
     * LogHandler constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function handle(Request $request, JsonResponse $response, Update $update): bool
    {
        $this
            ->collection
            ->insertOne([
                'logAt' => new UTCDateTime((int)microtime(true)),
                'update' => $update->getData(),
            ]);

        return true;
    }
}