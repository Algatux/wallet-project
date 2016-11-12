<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    private $firstName;
    /**
     * @var string
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    private $lastName;
    /**
     * @var string
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    private $nickName;
    /**
     * @var Wallet[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Wallet", inversedBy="sharedWith")
     * @ORM\JoinTable(name="users_wallets")
     */
    private $viewableWallets;

    public function __construct()
    {
        parent::__construct();
        $this->viewableWallets = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getNickName(): string
    {
        return $this->nickName;
    }

    /**
     * @param string $nickName
     */
    public function setNickName(string $nickName)
    {
        $this->nickName = $nickName;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        parent::setUsername($username);

        $this->nickName = $this->username;

        return $this;
    }

    /**
     * @return Wallet[]|ArrayCollection
     */
    public function getViewableWallets()
    {
        return $this->viewableWallets;
    }

    /**
     * @param Wallet[]|ArrayCollection $viewableWallets
     */
    public function setViewableWallets($viewableWallets)
    {
        $this->viewableWallets = $viewableWallets;
    }
}