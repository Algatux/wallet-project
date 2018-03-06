<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="refresh_token", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="token_idx", columns={"token"})
 * })
 * @ORM\Entity(repositoryClass="App\Repository\RefreshTokenRepository")
 */
class RefreshToken implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=256, nullable=false)
     */
    private $token;
    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false, options={"default":0})
     */
    private $revoked;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->revoked = false;
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
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function isRevoked(): bool
    {
        return $this->revoked;
    }

    /**
     * @param boolean $revoked
     */
    public function setRevoked(boolean $revoked)
    {
        $this->revoked = $revoked;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function jsonSerialize()
    {
        return [
            'tokenId' => $this->getId(),
            'token' => $this->getToken(),
            'user' => $this->getUser()->getId(),
            'revoked' => $this->revoked
        ];
    }
}
