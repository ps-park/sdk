<?php

declare(strict_types=1);

namespace PsPark\Factory;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PsPark\ClientInterface;
use PsPark\Config;
use PsPark\ConfigInterface;

class ClientFactoryTest extends TestCase
{
    private Config|MockObject $requestConfigMock;

    protected function setUp(): void
    {
        $this->requestConfigMock = $this->getMockBuilder(ConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }

    public function testCreate(): void
    {
        $this->requestConfigMock
            ->expects($this->once())
            ->method('getJwtKey')
            ->willReturn('secrete-key');
        $this->requestConfigMock
            ->expects($this->once())
            ->method('getApiKey')
            ->willReturn('secrete-key');

        $clientFactory = new ClientFactory($this->requestConfigMock);

        $this->assertInstanceOf(ClientInterface::class, $clientFactory->create());
    }
}
