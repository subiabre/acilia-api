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
     * @param array $data Body data
     * @param int $status HTTP status code
     * @return self
     */
    public function error(array $data, int $status = 400): self
    {
        $this->setData(['error' => $data]);
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
