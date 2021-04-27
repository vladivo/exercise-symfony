<?php

declare(strict_types=1);

namespace App\Model\Error;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

final class Error
{
    private function __construct(
        private ?int $status = null,
        private ?string $title = null,
        private ?string $source = null,
        private ?string $code = null,
    ) {}

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public static function fromConstraintViolation(ConstraintViolationInterface $error): self
    {
        return new self(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $error->getMessage(),
            $error->getPropertyPath(),
            $error->getCode()
        );
    }

    public static function fromResetPasswordException(ResetPasswordExceptionInterface $e): self
    {
        return new self(Response::HTTP_FORBIDDEN, $e->getReason());
    }

    public static function fromHttpException(HttpException $e): self
    {
        $status = $e->getStatusCode();
        $title = Response::$statusTexts[$status];

        return new self($status, $title);
    }

    public static function fromInternalError(): self
    {
        $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        $title = Response::$statusTexts[$status];

        return new self($status, $title);
    }
}
