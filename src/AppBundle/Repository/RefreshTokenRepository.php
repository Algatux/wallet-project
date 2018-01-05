<?php

namespace AppBundle\Repository;

use AppBundle\Entity\RefreshToken;
use AppBundle\Entity\User;
use Doctrine\ORM\QueryBuilder;

class RefreshTokenRepository extends AppRepository
{

    public function getQueryBuilder(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('refresh_token');

        return $qb;
    }

    /**
     * @param User $user
     *
     * @return RefreshToken|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getExistentValidTokenForUser(User $user)
    {
        $qb = $this->getQueryBuilder();

        $qb->where('NOT refresh_token.revoked');
        $qb->andWhere('refresh_token.user = :user');

        $qb->setParameter('user', $user->getId());

        return $qb->getQuery()->getOneOrNullResult();
    }
}
