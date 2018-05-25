<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Contracts\TimeblameableInterface;
use AppBundle\Entity\Traits\TimeblameableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="wallet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WalletRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=20)
 * @ORM\DiscriminatorMap({
 *      "type_monthly" = "AppBundle\Entity\MonthlyWallet",
 * })
 * @Serializer\ExclusionPolicy("all")
 */
abstract class Wallet implements TimeblameableInterface
{
    use TimeblameableEntity;

    const TYPE_MONTH = 'month';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose()
     * @Serializer\Groups({"wallet","transaction"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotNull()
     * @Serializer\Expose()
     * @Serializer\Groups({"wallet"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @Serializer\Expose()
     * @Serializer\Groups({"wallet"})
     */
    private $description;
    /**
     * @var bool
     *
     * @ORM\Column(name="settled", type="boolean", options={"default": false}, nullable=false)
     * @Serializer\Expose()
     * @Serializer\Groups({"wallet"})
     */
    private $settled;

    /**
     * @var Transaction[]|Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Transaction", mappedBy="wallet", cascade={"persist","remove"})
     */
    private $transactions;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @Serializer\Expose()
     * @Serializer\Groups({"wallet"})
     */
    private $owner;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="viewableWallets", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="users_wallets")
     * @Serializer\Groups({"wallet"})
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
     * @Serializer\Expose()
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("transactions")
     * @Serializer\Groups({"wallet"})
     *
     * @return array
     */
    public function getTransactionIds(): array
    {
        return $this->getTransactions()->map(function(Transaction $transaction){
            return $transaction->getId();
        })->toArray();
    }

    /**
     * @Serializer\Expose()
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("transactionAmount")
     * @Serializer\Groups({"wallet"})
     *
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
     * @Serializer\Expose()
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("sharedWith")
     * @Serializer\Groups({"wallet"})
     *
     * @return array
     */
    public function getSharedWithIds():array
    {
        return $this->getSharedWith()->map(function(User $user){
            return $user->getId();
        })->toArray();
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
