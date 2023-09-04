<?php

declare(strict_types=1);

namespace PsPark\Middleware\Response;

use PsPark\Exception\ResponseValidationException;
use PsPark\Handler\ResponseHandlerInterface;
use PsPark\Request\ResponseInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ResponseValidationMiddlewareTest extends TestCase
{
    private ResponseInterface|MockObject $responseMock;

    /**
     * @var ResponseHandlerInterface|MockObject
     */
    private ResponseHandlerInterface|MockObject $responseHandlerMock;

    protected function setUp(): void
    {
        $this->responseMock        = $this->getMockForAbstractClass(ResponseInterface::class);
        $this->responseHandlerMock = $this->getMockForAbstractClass(ResponseHandlerInterface::class);
    }

    /**
     * @param array $responseData
     *
     * @dataProvider validationErrorDataProvider
     */
    public function testProcess(array $responseData): void
    {
        $this->responseMock
            ->method('asArray')
            ->willReturn($responseData);

        if (count($responseData) === 0) {
            $this->responseHandlerMock
                ->expects($this->once())
                ->method('handle')
                ->with($this->equalTo($this->responseMock));
        } else {
            $this->responseHandlerMock
                ->expects($this->never())
                ->method('handle');

            $this->expectException(ResponseValidationException::class);
            $this->expectExceptionCode($responseData['code']);
            $this->expectExceptionMessage($responseData['message']);
        }

        $validationErrorMiddleware = new ResponseValidationMiddleware();
        $validationErrorMiddleware->handle($this->responseMock, $this->responseHandlerMock);
    }

    /**
     * @return array[][]
     */
    public function validationErrorDataProvider(): array
    {
        return [
            'merchant not found error'    => [[
                'code'    => 1001,
                'message' => 'Merchant Not Found',
                'data'    => [],
            ]],
            'request data error'          => [[
                'code'    => 1002,
                'message' => 'Request Data Error',
                'data'    => [],
            ]],
            'forbidden request error'     => [[
                'code'    => 1003,
                'message' => 'Forbidden this request',
                'data'    => [],
            ]],
            'insufficient funds error'    => [[
                'code'    => 1004,
                'message' => 'Insufficient Funds',
                'data'    => [],
            ]],
            'currency not allowed error'  => [[
                'code'    => 1006,
                'message' => 'Currency Not Allowed',
                'data'    => [],
            ]],
            'Transaction not found error' => [[
                'code'    => 1007,
                'message' => 'Transaction not found',
                'data'    => [],
            ]],
            'Gateway not configured error' => [[
                'code'    => 1008,
                'message' => 'Gateway not configured',
                'data'    => [],
            ]],
            'without error'               => [[]],
        ];
    }
}
