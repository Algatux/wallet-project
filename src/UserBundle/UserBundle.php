<?php

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class UserBundle
 * @package UserBundle
 */
class UserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
