<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\TestCase;
use PsPark\Trait\JwtIssuerTrait;

class BalancesRequestTest extends TestCase
{
    use JwtIssuerTrait;

    public function testAsArray(): void
    {
        $balanceDto = new BalancesRequest($testNonce = time());

        $this->assertEquals(['nonce' => $testNonce, ...$this->getIssuedAndExpirationTimes()], $balanceDto->asArray());
    }
}
