<?php

namespace CompanyInfoApi\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiExceptionListener implements EventSubscriberInterface
{
    /**
     * @param ExceptionEvent $event
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request   = $event->getRequest();

        if ('application/json' !== $request->headers->get('Content-Type')) {
            return;
        }

        $statusCode = $this->getStatusCodeFromException($exception);
        $headers = $this->getHeadersFromException($exception);

        $response = $this->createJsonResponse($exception, $statusCode, $headers);
        $event->setResponse($response);
    }

    /**
     * @param \Throwable $exception
     * @return int
     */
    private function getStatusCodeFromException(\Throwable $exception): int
    {
        if ($exception instanceof \InvalidArgumentException) {
            return Response::HTTP_BAD_REQUEST;
        }

        return $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * @param \Throwable $exception
     * @return array<string, string> Headers as a key-value array.
     */
    private function getHeadersFromException(\Throwable $exception): array
    {
        return $exception instanceof HttpExceptionInterface
            ? $exception->getHeaders()
            : [];
    }

    /**
     * @param \Throwable $exception
     * @param int $statusCode
     * @param array<string, string> $headers
     * @return JsonResponse
     */
    private function createJsonResponse(\Throwable $exception, int $statusCode, array $headers): JsonResponse
    {
        $response = new JsonResponse([
            'message' => $exception->getMessage(),
            'code' => $statusCode,
            'traces' => $exception->getTrace(),
        ]);

        $response->setStatusCode($statusCode);

        if (!empty($headers)) {
            $response->headers->replace($headers);
        }

        return $response;
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}