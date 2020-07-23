<?php

namespace App\Component;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides a nicer, shorter API over the Symfony default to retrieve JSON responses
 */
class ApiResponse extends JsonResponse
{
    /**
     * Send an error formatted response
     * @param string $message Error summary
     * @param array $errors Error list
     * @param int $status HTTP status code
     * @return self
     */
    public function error(string $message, array $errors, int $status = 400): self
    {
        $this->setData(['error' => ['message' => $message, 'errors' => $errors]]);
        $this->setStatusCode($status);

        return $this;
    }

    /**
     * Send a successful formatted response
     * @param array $data Body data
     * @param int $status HTTP status code
     * @return self
     */
    public function data(array $data, int $status = 200): self
    {
        $this->setData(['data' => $data]);
        $this->setStatusCode($status);

        return $this;
    }
}
