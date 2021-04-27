<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Entity\User\Account;
use App\Repository\Security\ResetPasswordRequestRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;

/**
 * @ORM\Entity(repositoryClass=ResetPasswordRequestRepository::class)
 */
final class ResetPasswordRequest implements ResetPasswordRequestInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $selector;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\Account", fetch="EAGER")
     * @ORM\JoinColumn(name="account", referencedColumnName="id")
     */
    private Account $account;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private DateTimeInterface $requestedAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private DateTimeInterface $expiresAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $hashedToken;

    public function getSelector(): string
    {
        return $this->selector;
    }

    public function setSelector(string $selector): void
    {
        $this->selector = $selector;
    }

    public function getUser(): Account
    {
        return $this->account;
    }

    public function setUser(Account $account): void
    {
        $this->account = $account;
    }

    public function getRequestedAt(): DateTimeInterface
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(DateTimeInterface $requestedAt): void
    {
        $this->requestedAt = $requestedAt;
    }

    public function getExpiresAt(): DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTimeInterface $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getHashedToken(): string
    {
        return $this->hashedToken;
    }

    public function setHashedToken(string $hashedToken): void
    {
        $this->hashedToken = $hashedToken;
    }

    public function isExpired(): bool
    {
        return $this->getExpiresAt() < new DateTimeImmutable();
    }
}
