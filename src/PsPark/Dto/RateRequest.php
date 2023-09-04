<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PsPark\Trait\JwtIssuerTrait;

class RateRequest implements RequestDtoInterface
{
    use JwtIssuerTrait;

    public function __construct(
        private readonly string $currencyFrom,
        private readonly string $currencyTo,
        private readonly int $nonce,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     currencyFrom: string,
     *     currencyTo: string,
     *     nonce: int,
     * }
     */
    public function asArray(): array
    {
        return [
            'currencyFrom' => $this->currencyFrom,
            'currencyTo'   => $this->currencyTo,
            'nonce'        => $this->nonce,
            ...$this->getIssuedAndExpirationTimes(),
        ];
    }
}
