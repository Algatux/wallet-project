<?php

declare(strict_types = 1);

namespace MailBundle\Mailer;

use AppBundle\Entity\Transaction;

class TransactionMailer extends Mailer
{
    /**
     * @param Transaction $transaction
     *
     * @return int
     */
    public function notifyTransactionCreated(Transaction $transaction)
    {
        $message = $this->getNewMessage('Vault - new transaction added!')
            ->setFrom('me@vault.algatux.it')
            ->setTo('a.galli85@gmail.com')
            ->setBody(
                sprintf(
                    'New Transaction of amount: %.2f € added by %s because of "%s"',
                    $transaction->getAmount(),
                    $transaction->getTransactedBy()->getNickName(),
                    $transaction->getMotivation()
                ),
                'text/html'
            );


        return $this->mailer()->send($message);
    }
}