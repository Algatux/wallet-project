<?php declare(strict_types=1);

namespace TelegramBundle\Service\Update\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TelegramBundle\Model\Update;

/**
 * Class DecoderHandler.
 */
class DecoderHandler extends AbstractHandler
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
