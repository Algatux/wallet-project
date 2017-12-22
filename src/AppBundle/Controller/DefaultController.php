<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="app_homepage")
     * @Template()
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/api/login", name="app_login")
     */
    public function loginAction()
    {
    }
}
