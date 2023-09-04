<?php

declare(strict_types=1);

namespace PsPark\Storage;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PsPark\Enum\ApiUrl;
use PsPark\Validator\ValidatorInterface;

class ValidatorStorageTest extends TestCase
{
    private ValidatorInterface|MockObject $validatorMock;

    protected function setUp(): void
    {
        $this->validatorMock = $this->getMockForAbstractClass(ValidatorInterface::class);
    }

    public function testStorage(): void
    {
        $url1 = ApiUrl::BALANCES;
        $validator1 = clone $this->validatorMock;
        $url2 = ApiUrl::WALLET_ADDRESS_CREATE;
        $validator2 = clone $this->validatorMock;
        $url3 = ApiUrl::RATES;
        $validator3 = clone $this->validatorMock;

        $storage = new ValidatorStorage();
        $storage->add($url1, $validator1);
        $storage->add($url2, $validator2);
        $storage->add($url3, $validator3);

        $this->assertEquals(3, $storage->count());
        $this->assertTrue($storage->exists($url2));
        $this->assertEquals($validator1, $storage->get($url1));
    }
}
