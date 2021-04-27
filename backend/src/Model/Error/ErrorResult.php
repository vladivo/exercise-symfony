<?php

declare(strict_types=1);

namespace App\Model\Error;

final class ErrorResult
{
    private function __construct(
        private ErrorCollection $errors,
    ) {}

    public function getErrors(): ErrorCollection
    {
        return $this->errors;
    }

    public static function fromErrorCollection(ErrorCollection $errors): self
    {
        return new self($errors);
    }
}
