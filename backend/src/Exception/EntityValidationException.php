<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class EntityValidationException extends UnprocessableEntityHttpException
{
    public function __construct(
        private ConstraintViolationListInterface $errors,
    ) {
        parent::__construct();
    }

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}
