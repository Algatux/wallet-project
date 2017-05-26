<?php declare(strict_types=1);

namespace TelegramBundle\Service\Update\Handler;

use MongoDB\BSON\UTCDateTime;
use MongoDB\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use TelegramBundle\Model\Update;
use TelegramBundle\Service\Update\HandlerInterface;

/**
 * Class DecoderHandler.
 */
class DecoderHandler extends AbstractHandler implements HandlerInterface
{
    public function handle(Request $request, JsonResponse $response, Update $update): bool
    {
        $data = json_decode($request->getContent());
        if (JSON_ERROR_NONE !== json_last_error()) {
            $response->setStatusCode(400);
            $response->setData([
                'code' => 400,
                'error' => 'Bad request: The update is not valid',
            ]);

            return false;
        }

        $update->setData($data);

        return true;
    }
}
