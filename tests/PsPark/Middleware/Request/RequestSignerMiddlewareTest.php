<?php

declare(strict_types=1);

namespace PsPark\Middleware\Request;

use Firebase\JWT\JWT;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PsPark\Handler\RequestHandlerInterface;
use PsPark\Request\RequestInterface;

class RequestSignerMiddlewareTest extends TestCase
{
    private RequestInterface|MockObject $requestMock;

    private RequestHandlerInterface|MockObject $requestHandlerMock;

    protected function setUp(): void
    {
        $this->requestMock        = $this->getMockForAbstractClass(RequestInterface::class);
        $this->requestHandlerMock = $this->getMockForAbstractClass(RequestHandlerInterface::class);
    }

    public function testProcess(): void
    {
        $testApiKey     = 'test-api-key';
        $testJwtKey     = openssl_pkey_new();
        $testPrivateKey = '';

        openssl_pkey_export($testJwtKey, $testPrivateKey);

        $testRequestBody = [
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => 'value3',
        ];

        $testSignature = "Bearer {$this->createSignature($testRequestBody, $testPrivateKey)}";

        $this->requestMock
            ->expects($this->exactly(2))
            ->method('withHeader')
            ->withConsecutive(
                [$this->equalTo('X-API-Key'), $this->equalTo($testApiKey)],
                [$this->equalTo('Authorization'), $this->equalTo($testSignature)]
            )
            ->willReturnOnConsecutiveCalls(
                $this->requestMock,
                $this->requestMock,
            );
        $this->requestMock
            ->expects($this->exactly(1))
            ->method('getBody')
            ->willReturn($testRequestBody);

        $this->requestHandlerMock
            ->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($this->requestMock));

        $signatureMiddleware = new RequestSignerMiddleware($testApiKey, $testPrivateKey);

        $this->assertInstanceOf(
            RequestInterface::class,
            $signatureMiddleware->handle($this->requestMock, $this->requestHandlerMock)
        );
    }

    private function createSignature(array $testPayload, string $testJwtKey): string
    {
        return JWT::encode($testPayload, $testJwtKey, 'RS256');
    }
}
