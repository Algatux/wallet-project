<?php

declare(strict_types = 1);

namespace MailBundle\Mailer;

use AppBundle\Entity\Transaction;
use AppBundle\Entity\User;

/**
 * Class TransactionMailer
 */
class TransactionMailer extends Mailer
{
    /**
     * @param Transaction $transaction
     *
     * @return int
     */
    public function notifyTransactionCreated(Transaction $transaction)
    {
        $to[] = $transaction->getWallet()->getOwner()->getEmail();

        /** @var User $user */
        foreach ($transaction->getWallet()->getSharedWith() as $user){
            $to[] = $user->getEmail();
        }

        $message = $this->getNewMessage('Vault - new transaction added!')
            ->setFrom('vault@algatux.it', 'Vault')
            ->setTo($to)
            ->setBody(
                $this->renderer()->render(
                    "@Mail/newTransaction.html.twig",
                    [
                        "transaction" => $transaction
                    ]
                ),
                'text/html'
            );


        return $this->mailer()->send($message);
    }
}