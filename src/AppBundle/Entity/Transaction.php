<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Contracts\FileAwareInterface;
use AppBundle\Entity\Contracts\TimeblameableInterface;
use AppBundle\Entity\Traits\FileAwareEntity;
use AppBundle\Entity\Traits\TimeblameableEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 */
class Transaction implements TimeblameableInterface, FileAwareInterface
{
    use TimeblameableEntity;
    use FileAwareEntity;

    const TYPE_IN = 1;
    const TYPE_OUT = 2;

    public static $readableType = [
        self::TYPE_IN   => 'IN',
        self::TYPE_OUT  => 'OUT',
    ];

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
     * @ORM\Column(name="motivation", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $motivation;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, options={"default":0.0})
     * @Assert\GreaterThanOrEqual(0.0)
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="smallint", options={"default"=1})
     */
    private $type;
    /**
     * @var Wallet
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Wallet", inversedBy="transactions")
     * @ORM\JoinColumn(name="wallet_id", referencedColumnName="id", nullable=false)
     */
    private $wallet;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="transacted_by_user_id", referencedColumnName="id", nullable=false)
     */
    private $transactedBy;

    /**
     * @var UploadedFile
     */
    private $uploadedFile;

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
     * Set motivation
     *
     * @param string $motivation
     *
     * @return Transaction
     */
    public function setMotivation($motivation)
    {
        $this->motivation = $motivation;

        return $this;
    }

    /**
     * Get motivation
     *
     * @return string
     */
    public function getMotivation()
    {
        return $this->motivation;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Transaction
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getReadableType(): string
    {
        return self::$readableType[$this->type];
    }

    /**
     * @return Wallet|null
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param Wallet $wallet
     */
    public function setWallet(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * @return User|null
     */
    public function getTransactedBy()
    {
        return $this->transactedBy;
    }

    /**
     * @param User $transactedBy
     */
    public function setTransactedBy(User $transactedBy)
    {
        $this->transactedBy = $transactedBy;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * @param UploadedFile $uploadedFile
     */
    public function setUploadedFile(UploadedFile $uploadedFile = null)
    {
        $this->uploadedFile = $uploadedFile;
    }
}

