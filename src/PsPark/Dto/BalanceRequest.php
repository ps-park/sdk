<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PsPark\Trait\JwtIssuerTrait;

class BalanceRequest implements RequestDtoInterface
{
    use JwtIssuerTrait;

    public function __construct(
        public readonly string $walletId,
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
