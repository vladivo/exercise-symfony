<?php

declare(strict_types=1);

namespace App\Response\Error\ResponseFactory;

use App\Exception\EntityValidationException;
use App\Model\Error\Error;
use App\Model\Error\ErrorCollection;
use App\Model\Error\ErrorResult;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

final class ErrorResponseFactory implements ResponseFactory
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    public function createValidationErrorResponse(EntityValidationException $e): Response
    {
        $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        $errors = ErrorCollection::fromConstraintViolationList($e->getErrors());

        return $this->createResponse($errors, $status);
    }

    public function createResetPasswordErrorResponse(ResetPasswordExceptionInterface $e): Response
    {
        $status = Response::HTTP_FORBIDDEN;
        $errors = ErrorCollection::fromError(Error::fromResetPasswordException($e));

        return $this->createResponse($errors, $status);
    }

    public function createHttpErrorResponse(HttpException $e): Response
    {
        $status = $e->getStatusCode();
        $errors = ErrorCollection::fromError(Error::fromHttpException($e));

        return $this->createResponse($errors, $status);
    }

    public function createInternalErrorResponse(): Response
    {
        $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        $errors = ErrorCollection::fromError(Error::fromInternalError());

        return $this->createResponse($errors, $status);
    }

    public function createResponse(ErrorCollection $collection, int $status): Response
    {
        $errorResult = ErrorResult::fromErrorCollection($collection);
        $data = $this->serializer->serialize($errorResult, 'json');
        $headers = ['Content-Type' => 'application/json'];

        return new Response($data, $status, $headers);
    }
}
