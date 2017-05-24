<?php declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TelegramController
 * @Route("/telegram")
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
        $this->get('logger')->addInfo($content);

        $update = json_decode($content);

        $this->get('app.service_telegram.telegram_client')->sendMessage([
            'chat_id' => $update->message->chat->id,
            'text' => 'scusa, non so cosa significhi, devo ancora imparare',
            'reply_to_message_id' => $update->message->message_id
        ]);

        return new JsonResponse([
            'status' => 200,
            'data' => []
        ]);
    }
}
