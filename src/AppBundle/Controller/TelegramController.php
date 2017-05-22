<?php declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class TelegramController
 * @Route("/telegram")
 */
class TelegramController extends BaseController
{
    /**
     * @Route("/hook", name="app_telegram_bot")
     *
     * @return RedirectResponse
     */
    public function hookAction()
    {
        return new RedirectResponse($this->generateUrl('app_homepage'));
    }
}
