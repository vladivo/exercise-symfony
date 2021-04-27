<?php

declare(strict_types=1);

namespace App\Response\Error\ResponseFactory;

use App\Exception\EntityValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

interface ResponseFactory
{
    public function createValidationErrorResponse(EntityValidationException $e): Response;
    public function createResetPasswordErrorResponse(ResetPasswordExceptionInterface $e): Response;
    public function createHttpErrorResponse(HttpException $e): Response;
    public function createInternalErrorResponse(): Response;
}
