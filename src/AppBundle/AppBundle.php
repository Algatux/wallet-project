<?php

namespace AppBundle;

use AppBundle\DependencyInjection\AppBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AppBundle
 */
class AppBundle extends Bundle
{
    /**
     * @return AppBundleExtension
     */
    public function getContainerExtension()
    {
        return new AppBundleExtension();
    }
}
