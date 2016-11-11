<?php

namespace AppBundle\Repository;

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
}
