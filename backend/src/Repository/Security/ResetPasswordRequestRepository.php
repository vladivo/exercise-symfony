<?php

declare(strict_types=1);

namespace App\Repository\Security;

use App\Entity\Security\ResetPasswordRequest;
use App\Entity\User\Account;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface;

/**
 * @method ResetPasswordRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResetPasswordRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResetPasswordRequest[]    findAll()
 * @method ResetPasswordRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ResetPasswordRequestRepository extends ServiceEntityRepository implements ResetPasswordRequestRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordRequest::class);
    }

    public function createResetPasswordRequest(
        object $user,
        DateTimeInterface $expiresAt,
        string $selector,
        string $hashedToken
    ): ResetPasswordRequestInterface {
        assert($user instanceof Account);

        $request = new ResetPasswordRequest();
        $request->setUser($user);
        $request->setRequestedAt(new DateTime());
        $request->setExpiresAt(DateTime::createFromInterface($expiresAt));
        $request->setSelector($selector);
        $request->setHashedToken($hashedToken);

        return $request;
    }

    public function getUserIdentifier(object $user): string
    {
        assert($user instanceof Account);

        return (string) $user->getId();
    }

    public function persistResetPasswordRequest(ResetPasswordRequestInterface $resetPasswordRequest): void
    {
        $manager = $this->getEntityManager();
        $manager->persist($resetPasswordRequest);
        $manager->flush();
    }

    public function findResetPasswordRequest(string $selector): ?ResetPasswordRequestInterface
    {
        return $this->find($selector);
    }

    public function getMostRecentNonExpiredRequestDate(object $user): ?DateTimeInterface
    {
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $request = $this
            ->createQueryBuilder('r')
            ->where('r.expiresAt < ?1')
            ->setParameter(1, $now)
            ->orderBy('r.expiresAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if ($request === null) {
            return null;
        }

        return $request->getRequestedAt();
    }

    public function removeResetPasswordRequest(ResetPasswordRequestInterface $resetPasswordRequest): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($resetPasswordRequest);
        $entityManager->flush();
    }

    public function removeExpiredResetPasswordRequests(): int
    {
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        return $this
            ->createQueryBuilder('r')
            ->delete()
            ->where('r.expiresAt < ?1')
            ->setParameter(1, $now)
            ->getQuery()
            ->getResult();
    }
}
