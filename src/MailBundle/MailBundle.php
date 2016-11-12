<?php

namespace MailBundle;

use MailBundle\DependencyInjection\MailBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MailBundle
 */
class MailBundle extends Bundle
{
    /**
     * @return MailBundleExtension
     */
    public function getContainerExtension()
    {
        return new MailBundleExtension();
    }
}
