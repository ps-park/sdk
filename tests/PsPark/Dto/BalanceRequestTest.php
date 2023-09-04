<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\TestCase;
use PsPark\Trait\JwtIssuerTrait;

class BalanceRequestTest extends TestCase
{
    use JwtIssuerTrait;

    public function testAsArray(): void
    {
        $balanceDto = new BalanceRequest(
            $walletId = 'wallet-id',
            $testNonce = time(),
        );

        $this->assertSame(['nonce' => $testNonce, ...$this->getIssuedAndExpirationTimes()], $balanceDto->asArray());
        $this->assertSame($walletId, $balanceDto->walletId);
    }
}
