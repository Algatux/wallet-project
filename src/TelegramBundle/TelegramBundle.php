<?php declare(strict_types=1);

namespace TelegramBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use TelegramBundle\DependencyInjection\TelegramBundleExtension;

/**
 * Class TelegramBundle.
 */
class TelegramBundle extends Bundle
{
    /**
     * @return TelegramBundleExtension
     */
    public function getContainerExtension()
    {
        return new TelegramBundleExtension();
    }
}
