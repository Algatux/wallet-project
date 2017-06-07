<?php declare(strict_types=1);

namespace AppBundle\Security;

use AppBundle\Entity\Transaction;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class TransactionVoter.
 */
class TransactionVoter extends Voter
{
    /** @var array|string[] */
    private $supportedAttributes = [
        'VIEW',
        'EDIT',
        'DELETE'
    ];

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed  $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Transaction) {
            return false;
        }

        if (!in_array(strtoupper($attribute), $this->supportedAttributes)) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute
     * @param mixed          $subject
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
            case 'EDIT':
            case 'DELETE':
                return $this->checkViewable($user, $subject);
        }

        return false;
    }

    /**
     * @param User   $user
     * @param Transaction $subject
     *
     * @return bool
     */
    private function checkViewable(User $user, Transaction $subject): bool
    {
        $wallets = $user->getViewableWallets();

        foreach ($wallets as $wallet) {
            if ($wallet->getId() === $subject->getWallet()->getId()) {
                return true;
            }
        }

        return false;
    }
}