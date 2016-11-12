<?php

declare(strict_types = 1);

namespace AppBundle\Security;

use AppBundle\Entity\User;
use AppBundle\Entity\Wallet;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class WalletVoter
 */
class WalletVoter extends Voter
{
    /** @var array|string[] */
    private $supportedAttributes = [
        'VIEW',
        'EDIT',
        'DELETE'
    ];

    /**
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Wallet) {
            return false;
        }

        if (!in_array(strtoupper($attribute), $this->supportedAttributes)) {
            return false;
        }

        return true;
    }

    /**
     * @param string         $attribute
     * @param Wallet         $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();

        if ($subject->getOwner()->getId() === $user->getId()) {
            return true;
        }

        $wallets = $user->getViewableWallets();

        foreach ($wallets as $wallet) {
            if ($wallet->getId() === $subject->getId()) {
                return true;
            }
        }

        return false;
    }
}