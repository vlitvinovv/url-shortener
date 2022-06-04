<?php

namespace App\Shared\Application\EventSubscriber;

use App\Shared\Application\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationExceptionSubscriber implements EventSubscriberInterface
{
    private ExceptionEvent $event;

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 1]
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $this->event = $event;

        $exception = $event->getThrowable();

        if (!$exception instanceof ValidationException) {
            return;
        }

        $description = [];
        $violations = $exception->getDescription();
        if ($violations instanceof ConstraintViolationList) {
            foreach ($violations as $violation) {
                $description[] = [
                    'error' => $violation->getMessage(),
                    'property_path' => $violation->getPropertyPath(),
                ];
            }

            $exception->setDescription($description);
        }

        if (!empty($description)) {
            $errorMessage = json_encode($description);
            $exception->setMessage($errorMessage);
        }

        $this->event->setResponse($exception->getJsonResponse());
    }
}