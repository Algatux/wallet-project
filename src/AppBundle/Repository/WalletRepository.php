<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Transaction;
use AppBundle\Entity\User;
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
     * @param User $user
     *
     * @return array
     */
    public function getVisibleWalletsByUser(User $user): array
    {
        $qb = $this->createQueryBuilder('wallet');

        $this->filterByOwnerOrSharedWith($qb, $user);

        return $qb->getQuery()->getResult();
    }

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

    /**
     * @param QueryBuilder $qb
     * @param User         $user
     *
     * @return QueryBuilder
     */
    public function filterByOwner(QueryBuilder $qb, User $user): QueryBuilder
    {
        $qb->andWhere('wallet.owner = :user');
        $qb->setParameter('user', $user->getId());

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param User         $user
     *
     * @return QueryBuilder
     */
    public function filterBySharedWith(QueryBuilder $qb, User $user): QueryBuilder
    {
        $qb->leftJoin('wallet.sharedWith', 'user');
        $qb->andWhere('user.id = :user');
        $qb->setParameter('user', $user->getId());

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param User         $user
     *
     * @return QueryBuilder
     */
    public function filterByOwnerOrSharedWith(QueryBuilder $qb, User $user): QueryBuilder
    {
        $qb->leftJoin('wallet.sharedWith', 'user');

        $qb->where('wallet.owner = :user');
        $qb->orWhere('user.id = :user');

        $qb->setParameter('user', $user->getId());
        $qb->setParameter('user', $user->getId());

        return $qb;
    }
}

