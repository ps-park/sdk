<?php

declare(strict_types=1);

namespace PsPark;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PsPark\Handler\RequestHandlerInterface;
use PsPark\Handler\ResponseHandlerInterface;
use PsPark\Request\RequestInterface;
use PsPark\Request\ResponseInterface;
use PsPark\Transport\TransportInterface;

class MiddlewareClientTest extends TestCase
{
    private RequestInterface|MockObject $requestMock;

    private ResponseInterface|MockObject $responseMock;

    private TransportInterface|MockObject $transportMock;

    private RequestHandlerInterface|MockObject $requestHandlerMock;

    private ResponseHandlerInterface|MockObject $responseHandlerMock;

    protected function setUp(): void
    {
        $this->requestMock         = $this->getMockForAbstractClass(RequestInterface::class);
        $this->responseMock        = $this->getMockForAbstractClass(ResponseInterface::class);
        $this->transportMock       = $this->getMockForAbstractClass(TransportInterface::class);
        $this->requestHandlerMock  = $this->getMockForAbstractClass(RequestHandlerInterface::class);
        $this->responseHandlerMock = $this->getMockForAbstractClass(ResponseHandlerInterface::class);
    }

    public function testSendRequest(): void
    {
        $this->requestHandlerMock
            ->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($this->requestMock))
            ->willReturn($this->requestMock);

        $this->transportMock
            ->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo($this->requestMock))
            ->willReturn($this->responseMock);

        $this->responseHandlerMock
            ->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($this->responseMock))
            ->willReturn($this->responseMock);

        $client = new ProxyClient(
            $this->transportMock,
            $this->requestHandlerMock,
            $this->responseHandlerMock
        );

        $client->sendRequest($this->requestMock);
    }
}
