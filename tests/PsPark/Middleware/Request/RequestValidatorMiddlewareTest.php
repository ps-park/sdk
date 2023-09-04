<?php

declare(strict_types=1);

namespace PsPark\Middleware\Request;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PsPark\Enum\ApiUrl;
use PsPark\Exception\RequestValidationException;
use PsPark\Handler\RequestHandlerInterface;
use PsPark\Request\RequestInterface;
use PsPark\Storage\StorageInterface;
use PsPark\Validator\ValidatorInterface;

class RequestValidatorMiddlewareTest extends TestCase
{
    private StorageInterface|MockObject $storageMock;

    private RequestInterface|MockObject $requestMock;

    private RequestHandlerInterface|MockObject $requestHandlerMock;

    private ValidatorInterface|MockObject $requestValidatorMock;

    protected function setUp(): void
    {
        $this->storageMock = $this->getMockForAbstractClass(StorageInterface::class);
        $this->requestMock = $this->getMockForAbstractClass(RequestInterface::class);
        $this->requestHandlerMock = $this->getMockForAbstractClass(RequestHandlerInterface::class);
        $this->requestValidatorMock = $this->getMockForAbstractClass(ValidatorInterface::class);
    }

    public function testProcessWithoutMiddlewares(): void
    {
        $testRequestUrl = ApiUrl::BALANCES;

        $this->storageMock
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo($testRequestUrl))
            ->willReturn(false);

        $this->requestMock
            ->expects($this->once())
            ->method('getUrl')
            ->willReturn($testRequestUrl);

        $this->requestHandlerMock
            ->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($this->requestMock))
            ->willReturn($this->requestMock);

        $requestValidatorMiddleware = new RequestValidatorMiddleware($this->storageMock);

        $this->assertInstanceOf(
            RequestInterface::class,
            $requestValidatorMiddleware->handle($this->requestMock, $this->requestHandlerMock)
        );
    }

    public function testProcessWithValidatorsAndWithoutErrors(): void
    {
        $testRequestUrl = ApiUrl::BALANCES;

        $this->storageMock
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo($testRequestUrl))
            ->willReturn(true);
        $this->storageMock
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo($testRequestUrl))
            ->willReturn($this->requestValidatorMock);

        $this->requestValidatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($this->equalTo($this->requestMock));
        $this->requestValidatorMock
            ->expects($this->once())
            ->method('hasErrors')
            ->willReturn(false);

        $this->requestMock
            ->expects($this->exactly(2))
            ->method('getUrl')
            ->willReturn($testRequestUrl);

        $this->requestHandlerMock
            ->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($this->requestMock))
            ->willReturn($this->requestMock);

        $requestValidatorMiddleware = new RequestValidatorMiddleware($this->storageMock);

        $this->assertInstanceOf(
            RequestInterface::class,
            $requestValidatorMiddleware->handle($this->requestMock, $this->requestHandlerMock)
        );
    }

    public function testProcessWithValidatorsAndWitErrors(): void
    {
        $testRequestUrl = ApiUrl::BALANCES;
        $testErrorMessages = [
            'First error message.',
            'Second error message.',
        ];

        $this->storageMock
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo($testRequestUrl))
            ->willReturn(true);
        $this->storageMock
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo($testRequestUrl))
            ->willReturn($this->requestValidatorMock);

        $this->requestValidatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($this->equalTo($this->requestMock));
        $this->requestValidatorMock
            ->expects($this->once())
            ->method('hasErrors')
            ->willReturn(true);
        $this->requestValidatorMock
            ->expects($this->once())
            ->method('getErrors')
            ->willReturn($testErrorMessages);

        $this->requestMock
            ->expects($this->exactly(2))
            ->method('getUrl')
            ->willReturn($testRequestUrl);

        $this->requestHandlerMock
            ->expects($this->never())
            ->method('handle');

        $this->expectException(RequestValidationException::class);
        $this->expectExceptionMessage(implode('; ', $testErrorMessages));

        $requestValidatorMiddleware = new RequestValidatorMiddleware($this->storageMock);
        $requestValidatorMiddleware->handle($this->requestMock, $this->requestHandlerMock);
    }
}
