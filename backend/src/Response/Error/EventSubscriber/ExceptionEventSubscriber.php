<?php

declare(strict_types=1);

namespace App\Response\Error\EventSubscriber;

use App\Exception\EntityValidationException;
use App\Response\Error\ResponseFactory\ResponseFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

final class ExceptionEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ResponseFactory $responseFactory,
        private LoggerInterface $logger,
    ) {}

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if ($e instanceof EntityValidationException) {
            $response = $this->responseFactory->createValidationErrorResponse($e);
        } elseif ($e instanceof ResetPasswordExceptionInterface) {
            $response = $this->responseFactory->createResetPasswordErrorResponse($e);
        } elseif ($e instanceof HttpException) {
            $response = $this->responseFactory->createHttpErrorResponse($e);
        } else {
            $this->logger->debug($e);
            $response = $this->responseFactory->createInternalErrorResponse();
        }

        $event->setResponse($response);
    }
}
