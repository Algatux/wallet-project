<?php

declare(strict_types=1);

namespace App\Entity\Contracts;

use App\Entity\User;

/**
 * Interface TimeblameableInterface
 */
interface TimeblameableInterface
{
    /**
     * @return \DateTime|null
     */
    public function getCreatedAt();

    /**
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt();

    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * @return User|null
     */
    public function getCreatedBy();

    /**
     * @param User|null $createdBy
     */
    public function setCreatedBy(User $createdBy = null);

    /**
     * @return User|null
     */
    public function getUpdatedBy();

    /**
     * @param User $updatedBy
     */
    public function setUpdatedBy(User $updatedBy = null);
}
