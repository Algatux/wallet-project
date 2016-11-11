<?php

declare(strict_types = 1);

namespace AppBundle\Twig;

use AppBundle\Entity\Transaction;

/**
 * Class AppBundleExtension
 */
class AppBundleExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('transaction_type', array($this, 'transactionType')),
        );
    }

    /**
     * @param int $type
     *
     * @return string
     */
    public function transactionType(int $type = null)
    {
        if (empty($type)) {
            return '---';
        }

        return Transaction::$readableType[$type];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_bundle_extension';
    }
}
