<?php

declare(strict_types=1);

namespace PsPark\Validator\Constraint;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PsPark\Validator\ValidatorInterface;

class UrlTest extends TestCase
{
    private ValidatorInterface|MockObject $validatorMock;

    protected function setUp(): void
    {
        $this->validatorMock = $this->getMockForAbstractClass(ValidatorInterface::class);
    }

    public function testMagicMethod(): void
    {
        $testAttributeName = 'test-name';

        $this->validatorMock
            ->expects($this->exactly(3))
            ->method('addError')
            ->with($this->equalTo(sprintf('The "%s" parameter is not a valid url!', $testAttributeName)));

        $constraint = new Url($testAttributeName);

        $constraint([$testAttributeName => ''], $this->validatorMock);
        $constraint([$testAttributeName => '  '], $this->validatorMock);
        $constraint([$testAttributeName => null], $this->validatorMock);
        $constraint([$testAttributeName => 'https://test.io'], $this->validatorMock);
    }
}
