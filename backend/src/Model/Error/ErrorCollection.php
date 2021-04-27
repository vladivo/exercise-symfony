<?php

declare(strict_types=1);

namespace App\Model\Error;

use ArrayIterator;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ErrorCollection extends ArrayIterator
{
    private function __construct(Error ...$errors)
    {
        parent::__construct($errors);
    }

    public static function fromError(Error $error): self
    {
        return new self($error);
    }

    public static function fromConstraintViolationList(ConstraintViolationListInterface $violations): self
    {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[] = Error::fromConstraintViolation($violation);
        }

        return new self(...$errors);
    }
}
