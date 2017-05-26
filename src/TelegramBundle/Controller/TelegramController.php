<?php declare(strict_types=1);

namespace TelegramBundle\Controller;

use AppBundle\Controller\BaseController;
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
     *
     * @return JsonResponse
     */
    public function hookAction(Request $request)
    {
        return $this
            ->get('telegram.service_update.handler')
            ->handle($request);
    }
}
