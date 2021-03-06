<?php

declare(strict_types = 1);

namespace AppBundle\Twig;

use AppBundle\Entity\MonthlyWallet;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\User;
use AppBundle\Entity\Wallet;
use Doctrine\Common\Collections\ArrayCollection;

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
            new \Twig_SimpleFilter('wallet_share_name_list', array($this, 'walletShareNameList')),
            new \Twig_SimpleFilter('wallet_info', array($this, 'walletInfo')),
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
     * @param Wallet $wallet
     *
     * @return string
     */
    public function walletShareNameList(Wallet $wallet): string
    {
        /** @var ArrayCollection|User[] $userList */
        $userList = $wallet->getSharedWith();
        $names = array_map(
            function(User $user){
                return $user->getNickName();
            },
            $userList->toArray()
        );

        return implode(', ', $names);
    }

    public function walletInfo(Wallet $wallet): string
    {
        if ($wallet instanceof MonthlyWallet) {
            return $wallet->isForceName() ? $wallet->getName() : $wallet->getReferenceMonth('F Y');
        }

        return $wallet->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_bundle_extension';
    }
}
