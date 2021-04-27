<?php

declare(strict_types=1);

namespace App\Security\Listener;

use App\Security\UserProvider\AnonymousUserProvider;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\AbstractListener;

final class AnonymousAuthenticationListener extends AbstractListener
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private string $secret,
        private LoggerInterface $logger,
        private AuthenticationManagerInterface $authenticationManager,
        private AnonymousUserProvider $anonymousUserProvider,
    ) {}

    public function supports(Request $request): ?bool
    {
        return null;
    }

    public function authenticate(RequestEvent $event): void
    {
        if (null !== $this->tokenStorage->getToken()) {
            return;
        }

        try {
            $token = new AnonymousToken($this->secret, $this->anonymousUserProvider->getUser(), []);
            if (null !== $this->authenticationManager) {
                $token = $this->authenticationManager->authenticate($token);
            }

            $this->tokenStorage->setToken($token);

            if (null !== $this->logger) {
                $this->logger->info('Populated the TokenStorage with an anonymous Token.');
            }
        } catch (AuthenticationException $failed) {
            if (null !== $this->logger) {
                $this->logger->info('Anonymous authentication failed.', ['exception' => $failed]);
            }
        }
    }
}
