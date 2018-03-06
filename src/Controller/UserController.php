<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use WsBundle\HttpComponents\Responses\JsonApiDocumentResponse;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route("/ws/users")
 */
class UserController extends BaseController
{

    /**
     * @Route("/", name="ws_users_list")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return JsonApiDocumentResponse
     */
    public function usersAction(Request $request)
    {
        $users = $this->getEntityManager()
            ->getRepository(User::class)->findAll();

        return new JsonApiDocumentResponse($users);
    }

    /**
     * @Route("/{user}", name="ws_user")
     * @Method({"GET"})
     *
     * @param Request $request
     * @param User $user
     * @return JsonApiDocumentResponse
     */
    public function userAction(Request $request, User $user)
    {
        return new JsonApiDocumentResponse($user);
    }
}
