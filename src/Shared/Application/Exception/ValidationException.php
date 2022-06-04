<?php

namespace App\Shared\Application\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends HttpException
{
    private $description;

    public function __construct(
        ConstraintViolationListInterface $description,
        string $message = 'exception.message.bad_validation'
    )
    {
        $this->description = $description;
        $this->message = $message;

        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getJsonResponse(): JsonResponse
    {
        $data['message'] = $this->getMessage();

        if (!empty($this->getDescription())) {
            $data['description'] = $this->getDescription();
        }

        return new JsonResponse($data);
    }
}