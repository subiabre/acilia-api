<?php

namespace App\EventSubscriber;

use App\Component\ApiResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var ApiResponse
     */
    private $response;

    public function __construct(ApiResponse $apiResponse)
    {
        $this->response = $apiResponse;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['sendResponse']
            ],
        ];
    }

    public function sendResponse(ExceptionEvent $exceptionEvent)
    {
        $exception = $exceptionEvent->getThrowable();

        $response = $this->response->error($exception->getMessage(), $exception->getTrace());

        $exceptionEvent->setResponse($response);
    }
}
