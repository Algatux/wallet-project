<?php declare(strict_types=1);

namespace TelegramBundle\Controller;

use AppBundle\Controller\BaseController;
use MongoDB\BSON\UTCDateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TelegramController
 */
class TelegramController extends BaseController
{
    /**
     * @Route("/hook/{token}", name="app_telegram_bot_hook")
     *
     * @param Request $request
     * @param string  $token
     *
     * @return JsonResponse
     */
    public function hookAction(Request $request, string $token)
    {
        if($token !== 'test'){
            throw $this->createAccessDeniedException();
        }

        $content = $request->getContent();
        $update = json_decode($content);

        $this->get('mongo.connection')
            ->selectCollection('telegram_webhook_logs')
            ->insertOne([
                'logAt' => new UTCDateTime((int)microtime(true)),
                'update' => $update,
            ]);

//        $this->get('app.service_telegram.telegram_client')->sendMessage([
//            'chat_id' => $update->message->chat->id,
//            'text' => 'scusa, non so cosa significhi, devo ancora imparare',
//            'reply_to_message_id' => $update->message->message_id
//        ]);

        return new JsonResponse([
            'status' => 200,
            'data' => []
        ]);
    }
}
