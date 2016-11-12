<?php

declare(strict_types = 1);

namespace MailBundle\Mailer;

use Swift_Mailer;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class Mailer
 */
abstract class Mailer
{
    /** @var TwigEngine */
    private $twigEngine;
    /** @var Swift_Mailer */
    private $mailer;

    /**
     * Mailer constructor.
     *
     * @param Swift_Mailer $mailer
     * @param TwigEngine   $twigEngine
     */
    public function __construct(Swift_Mailer $mailer, TwigEngine $twigEngine)
    {
        $this->twigEngine = $twigEngine;
        $this->mailer = $mailer;
    }

    /**
     * @return TwigEngine
     */
    protected function renderer(): TwigEngine
    {
        $this->twigEngine;
    }

    /**
     * @return Swift_Mailer
     */
    protected function mailer(): Swift_Mailer
    {
        return $this->mailer;
    }

    /**
     * @param string|null $subject
     * @param null        $body
     * @param null        $contentType
     * @param null        $charset
     *
     * @return \Swift_Message
     */
    protected function getNewMessage(
        string $subject = null,
        $body = null,
        $contentType = null,
        $charset = null
    ): \Swift_Message
    {
        return \Swift_Message::newInstance($subject, $body, $contentType, $charset);
    }
}
