<?php

declare(strict_types = 1);

namespace AppBundle\Entity\Subscriber;

use AppBundle\Entity\Contracts\TimeblameableInterface;
use AppBundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class TimeblameableSubscriber implements EventSubscriber
{
    /** @var TokenStorage */
    private $tokenStorage;

    /**
     * TimeblameableSubscriber constructor.
     *
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate'
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return bool
     */
    private function isSupported(LifecycleEventArgs $args): bool
    {
        if ($args->getEntity() instanceof TimeblameableInterface) {
            return true;
        }

        return false;
    }

    /**
     * @return User|null
     */
    private function getCurrentUser()
    {
        $token = $this->tokenStorage->getToken();
        if (null === $token) {
            return null;
        }

        return $token->getUser();
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        if (!$this->isSupported($args)) {
            return;
        }

        /** @var TimeblameableInterface $entity */
        $entity = $args->getEntity();
        $entity->setCreatedAt(new \DateTime());
        $entity->setCreatedBy($this->getCurrentUser());
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        if (!$this->isSupported($args)) {
            return;
        }

        /** @var TimeblameableInterface $entity */
        $entity = $args->getEntity();
        $entity->setUpdatedAt(new \DateTime());
        $entity->setUpdatedBy($this->getCurrentUser());
    }
}
