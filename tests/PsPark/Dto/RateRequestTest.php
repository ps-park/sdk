<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\TestCase;
use PsPark\Trait\JwtIssuerTrait;

class RateRequestTest extends TestCase
{
    use JwtIssuerTrait;

    public function testAsArray(): void
    {
        $attributes = [
            'currencyFrom' => 'USD',
            'currencyTo'   => 'BTC',
            'nonce'        => time(),
        ];

        $this->assertEquals(
            [...$attributes, ...$this->getIssuedAndExpirationTimes()],
            (new RateRequest(...$attributes))->asArray()
        );
    }
}
