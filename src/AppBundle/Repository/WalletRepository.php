<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Transaction;
use AppBundle\Entity\Wallet;
use Doctrine\ORM\Query\Expr\GroupBy;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * WalletRepository
 */
class WalletRepository extends EntityRepository
{
    /**
     * @param Wallet $wallet
     *
     * @return float
     */
    public function getTotalAmountTrasferedByWallet(Wallet $wallet): float
    {
        $qb = $this->createQueryBuilder('wallet');
        $qb->select('SUM(transactions.amount) as amount');
        $qb->addSelect('transactions.type as type');

        $qb->leftJoin('wallet.transactions', 'transactions');

        $this->filterByWallet($qb, $wallet);

        $qb->groupBy('transactions.type');

        $results = $qb->getQuery()->getResult();

        $total = 0;
        foreach ($results as $result) {
            if ($result['type'] === Transaction::TYPE_IN) {
                $total += (float) $result['amount'];
                continue;
            }

            $total -= (float) $result['amount'];
        }

        return $total;
    }

    /**
     * @param Wallet $wallet
     *
     * @return array
     */
    public function getSingleTransactionerAmountByWallet(Wallet $wallet): array
    {
        $qb = $this->createQueryBuilder('wallet');
        $qb->select('users.nickName as name');
        $qb->addSelect('transactions.type as type');
        $qb->addSelect('SUM(transactions.amount) as amount');

        $qb->leftJoin('wallet.transactions', 'transactions');
        $qb->leftJoin('transactions.transactedBy', 'users');

        $qb->groupBy('transactions.transactedBy', 'transactions.type');

        $this->filterByWallet($qb, $wallet);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param QueryBuilder $qb
     * @param Wallet       $wallet
     *
     * @return QueryBuilder
     */
    public function filterByWallet(QueryBuilder $qb, Wallet $wallet): QueryBuilder
    {
        $qb->andWhere('wallet.id = :wallet');
        $qb->setParameter('wallet', $wallet->getId());

        return $qb;
    }
}

