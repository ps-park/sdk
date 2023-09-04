<?php

declare(strict_types=1);

namespace PsPark\Handler;

use PsPark\Middleware\ResponseMiddlewareInterface;
use PsPark\Request\ResponseInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ResponseHandlerTest extends TestCase
{
    private ResponseInterface|MockObject $responseMock;

    private ResponseMiddlewareInterface|MockObject $responseMiddlewareMock;

    protected function setUp(): void
    {
        $this->responseMock           = $this->getMockForAbstractClass(ResponseInterface::class);
        $this->responseMiddlewareMock = $this->getMockForAbstractClass(ResponseMiddlewareInterface::class);
    }

    public function testHandle(): void
    {
        $responseMiddlewareMock1 = clone $this->responseMiddlewareMock;
        $responseMiddlewareMock2 = clone $this->responseMiddlewareMock;

        $responseHandler = new ResponseHandler([
            $this->responseMiddlewareMock,
            $responseMiddlewareMock1,
            $responseMiddlewareMock2,
        ]);

        $this->responseMiddlewareMock
            ->expects($this->once())
            ->method('handle')
            ->with(
                $this->equalTo($this->responseMock),
                $this->equalTo($responseHandler)
            );
        $responseMiddlewareMock1
            ->expects($this->once())
            ->method('handle')
            ->with(
                $this->equalTo($this->responseMock),
                $this->equalTo($responseHandler)
            );
        $responseMiddlewareMock2
            ->expects($this->once())
            ->method('handle')
            ->with(
                $this->equalTo($this->responseMock),
                $this->equalTo($responseHandler)
            );

        $this->assertInstanceOf(ResponseInterface::class, $responseHandler->handle($this->responseMock));
    }
}
