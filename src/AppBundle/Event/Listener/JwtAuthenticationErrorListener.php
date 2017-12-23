<?php declare(strict_types = 1);

namespace AppBundle\Event\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class JwtAuthenticationErrorListener.
 */
class JwtAuthenticationErrorListener
{
    /**
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        $event->setResponse($this->buildErrorResponse(401, 'Unauthorized, Bad credentials'));
    }

    /**
     * @param AuthenticationFailureEvent $event
     */
    public function onJWTInvalidOrExpired(AuthenticationFailureEvent $event)
    {
        $event->setResponse($this->buildErrorResponse(401, 'Unauthorized, Jwt Token invalid or Expired'));
    }

    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $event->setResponse($this->buildErrorResponse(401, 'Unauthorized, Jwt token not found'));
    }

    /**
     * @param int    $code
     * @param string $message
     *
     * @return JsonResponse
     */
    private function buildErrorResponse(int $code, string $message): JsonResponse
    {
        return new JsonResponse(
            [
                "error" => [
                    "code" => $code,
                    "message" => $message
                ]
            ],
            $code
        );
    }
}
