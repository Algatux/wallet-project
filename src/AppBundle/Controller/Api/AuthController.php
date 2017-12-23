<?php declare(strict_types=1);

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthController extends Controller
{
    /**
     * @Route("/api/login", name="api_jwt_login" )
     * @Method({"POST"})
     *
     * @throws \Exception
     */
    public function loginAction()
    {
        throw new \Exception('No access here!');
    }
}
