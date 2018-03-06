<?php declare(strict_types = 1);

namespace App\Security;

use App\Entity\User;
use App\Entity\Wallet;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class WalletVoter
 */
class WalletVoter extends Voter
{
    /** @var array|string[] */
    private $supportedAttributes = [
        'TRANSACT',
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

        switch($attribute) {
            case 'VIEW':
            case 'TRANSACT':
                return $this->checkViewable($user, $subject);
            case 'EDIT':
            case 'DELETE':
                return $this->checkOwnership($user, $subject);
        }

        return false;
    }

    /**
     * @param User   $user
     * @param Wallet $subject
     *
     * @return bool
     */
    private function checkViewable(User $user, Wallet $subject): bool
    {
        $wallets = $user->getViewableWallets();

        foreach ($wallets as $wallet) {
            if ($wallet->getId() === $subject->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param User   $user
     * @param Wallet $subject
     *
     * @return bool
     */
    private function checkOwnership(User $user, Wallet $subject): bool
    {
        return $user->getId() === $subject->getOwner()->getId();
    }
}