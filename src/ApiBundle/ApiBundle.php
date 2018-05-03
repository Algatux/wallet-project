<?php

namespace ApiBundle;

use ApiBundle\DependencyInjection\ApiBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApiBundle extends Bundle
{
    /**
     * @return ApiBundleExtension
     */
    public function getContainerExtension()
    {
        return new ApiBundleExtension();
    }
}
