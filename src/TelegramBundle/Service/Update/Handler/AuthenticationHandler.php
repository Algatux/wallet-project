<?php declare(strict_types=1);

namespace TelegramBundle\Service\Update\Handler;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TelegramBundle\Model\Update;
use TelegramBundle\Service\Update\HandlerInterface;

/**
 * Class AuthenticationHandler.
 */
class AuthenticationHandler extends AbstractHandler implements HandlerInterface
{
    /** @var UserRepository */
    private $userRepository;
    /** @var string */
    private $webHookToken;

    public function __construct(EntityManagerInterface $entityManager, string $webHookToken)
    {
        $this->userRepository = $entityManager->getRepository(User::class);
        $this->webHookToken = $webHookToken;
    }

    public function handle(Request $request, JsonResponse $response, Update $update): bool
    {
        if (!$this->checkToken($request) || !$this->checkUser($request)) {
            $response->setStatusCode(401);
            $response->setData([
                'code' => 401,
                'error' => 'Access denied, you are not allowed'
            ]);

            return false;
        }

        return true;
    }

    private function checkToken(Request $request): bool
    {
        return $this->webHookToken === $request->get('token');
    }

    private function checkUser(Request $request): bool
    {
        return true;
    }
}
