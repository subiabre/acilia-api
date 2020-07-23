<?php

namespace App\Tests\Component;

use App\Component\ApiResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseTest extends TestCase
{
    public function testErrorReturnsExpectedResponse()
    {
        $response = new ApiResponse();
        $message = 'Error message';
        $data = ['key' => 'value'];

        $expected = new JsonResponse(['error' => ['message' => $message, 'errors' => $data]], 400);
        $actual = $response->error($message, $data);
        
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertInstanceOf(JsonResponse::class, $actual);

        $this->assertSame($expected->getContent(), $actual->getContent());
        $this->assertSame($expected->getStatusCode(), $actual->getStatusCode());
    }

    public function testDataReturnsExpectedResponse()
    {
        $response = new ApiResponse();
        $data = ['key' => 'value'];

        $expected = new JsonResponse(['data' => $data], 200);
        $actual = $response->data($data);
        
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertInstanceOf(JsonResponse::class, $actual);

        $this->assertSame($expected->getContent(), $actual->getContent());
        $this->assertSame($expected->getStatusCode(), $actual->getStatusCode());
    }
}
