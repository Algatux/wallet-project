<?php

namespace AppBundle\Entity;

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
class Wallet
{
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="viewableWallets", cascade={"persist", "remove"})
     */
    private $sharedWith;

    /**
     * Wallet constructor.
     */
    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->sharedWith = new ArrayCollection();
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
     * @return Transaction[]|Collection
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    /**
     * @return User
     */
    public function getOwner(): User
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
        dump('set');
        $this->sharedWith = $sharedWith;
    }

    /**
     * @param User $user
     */
    public function addSharedWith(User $user)
    {
        dump('add in wallet');
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
