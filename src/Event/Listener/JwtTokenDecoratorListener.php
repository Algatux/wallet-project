<?php declare(strict_types = 1);

namespace App\Event\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

/**
 * Class JwtTokenDecoratorListener.
 */
class JwtTokenDecoratorListener
{
    /**
     * @param JWTCreatedEvent $event
     */
    public function onTokenCreated(JWTCreatedEvent $event)
    {
        $this->clearRoles($event); //With our role list the token is too big to be sent by header!!
    }

    /**
     * @param JWTCreatedEvent $event
     */
    private function clearRoles(JWTCreatedEvent $event)
    {
        $payload = $event->getData();

        if(array_key_exists('roles', $payload)){
            unset($payload['roles']);
        }

        $event->setData($payload);
    }
}
