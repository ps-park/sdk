<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PsPark\Trait\JwtIssuerTrait;

class BalancesRequest implements RequestDtoInterface
{
    use JwtIssuerTrait;

    public function __construct(
        private readonly int $nonce,
    ) {
    }

    /**
     * @psalm-return array{nonce: int|null}
     */
    public function asArray(): array
    {
        return [
            'nonce' => $this->nonce,
            ...$this->getIssuedAndExpirationTimes(),
        ];
    }
}
