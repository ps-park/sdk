<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\TestCase;
use PsPark\Trait\JwtIssuerTrait;

class TransactionRequestTest extends TestCase
{
    use JwtIssuerTrait;

    public function testAsArray(): void
    {
        $testUuid  = 'uuid';
        $testNonce = 123456;

        $this->assertEquals(
            [
                'reference' => $testUuid,
                'nonce'     => $testNonce,
                ...$this->getIssuedAndExpirationTimes(),
            ],
            (new TransactionRequest($testUuid, $testNonce))->asArray()
        );
    }
}
