<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Contracts\TimeblameableInterface;
use AppBundle\Entity\Traits\TimeblameableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Wallet
 *
 * @ORM\Table(name="wallet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WalletRepository")
 */
class Wallet implements TimeblameableInterface
{
    use TimeblameableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotNull()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;
    /**
     * @var bool
     *
     * @ORM\Column(name="settled", type="boolean", options={"default": false}, nullable=false)
     */
    private $settled;

    /**
     * @var Transaction[]|Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Transaction", mappedBy="wallet", cascade={"persist","remove"})
     */
    private $transactions;

    /**
     * var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $owner;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="viewableWallets", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="users_wallets")
     */
    private $sharedWith;

    /**
     * Wallet constructor.
     */
    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->sharedWith = new ArrayCollection();
        $this->settled = false;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Wallet
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isSettled(): bool
    {
        return $this->settled;
    }

    /**
     * @param bool $settled
     */
    public function setSettled(bool $settled)
    {
        $this->settled = $settled;
    }

    /**
     * @return Transaction[]|Collection
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    /**
     * @return float
     */
    public function getTransactionsTotalAmount(): float
    {
        $transactions = $this->getTransactions();

        if ($transactions->isEmpty()) {
            return .0;
        }

        return array_reduce(
            $transactions->toArray(),
            function($carry, Transaction $tr){
                return $carry + $tr->getFloatAmount();
            },
            .0
        );
    }

    /**
     * @return User|null
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return Collection
     */
    public function getSharedWith(): Collection
    {
        return $this->sharedWith;
    }

    /**
     * @param ArrayCollection $sharedWith
     */
    public function setSharedWith(ArrayCollection $sharedWith)
    {
        $this->sharedWith = $sharedWith;
    }

    /**
     * @param User $user
     */
    public function addSharedWith(User $user)
    {
        if (!$this->sharedWith->contains($user)) {
            $this->sharedWith->add($user);
            $user->addViewableWallet($this);
        }

    }

    /**
     * @param User $user
     */
    public function removeSharedWith(User $user)
    {
        if ($this->sharedWith->contains($user)) {
            $this->sharedWith->removeElement($user);
            $user->removeViewableWallet($this);
        }
    }
}
