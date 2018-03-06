<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class BaseController
 */
abstract class BaseController extends Controller
{
    /**
     * @return EntityManagerInterface
     */
    protected function getEm(): EntityManagerInterface
    {
        return $this->get('doctrine.orm.default_entity_manager');
    }

    /**
     * @param string $repoClassName
     *
     * @return ObjectRepository
     */
    protected function getRepository(string $repoClassName): ObjectRepository
    {
        return $this->getEm()->getRepository($repoClassName);
    }

    /**
     * @return EventDispatcherInterface
     */
    protected function getEd(): EventDispatcherInterface
    {
        return $this->get('event_dispatcher');
    }

    protected function flashNotification(string $message)
    {
        $this->addFlash('notice', $message);
    }

    protected function flashError(string $message)
    {
        $this->addFlash('error', $message);
    }
}
