<?php

declare(strict_types=1);

namespace Validator\Constraint;

use PsPark\Validator\Constraint\Required;
use PsPark\Validator\ValidatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RequiredTest extends TestCase
{
    private ValidatorInterface|MockObject $validatorMock;

    protected function setUp(): void
    {
        $this->validatorMock = $this->getMockForAbstractClass(ValidatorInterface::class);
    }

    public function testInvokeMagicMethod(): void
    {
        $testAttributeName = 'test-name';

        $this->validatorMock
            ->expects($this->exactly(4))
            ->method('addError')
            ->with($this->equalTo(sprintf('The "%s" parameter is required!', $testAttributeName)));

        $constraint = new Required($testAttributeName);

        $constraint([], $this->validatorMock);
        $constraint([$testAttributeName => ''], $this->validatorMock);
        $constraint([$testAttributeName => '  '], $this->validatorMock);
        $constraint([$testAttributeName => null], $this->validatorMock);
    }
}
