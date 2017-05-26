<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * UserRepository.
 */
class UserRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getUserListQueryBuilder(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('user');

        return $qb;
    }

    /**
     * @param int $telegramId
     *
     * @return User|null
     */
    public function getUserByTelegramId(int $telegramId)
    {
        $qb = $this->createQueryBuilder('user');

        $qb->select('COUNT(user.id)');

        $qb->where('user.telegramId = :telegramId');
        $qb->setParameter('telegramId', $telegramId);

        return $qb->getQuery()->getSingleScalarResult();
    }
}
