<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PsPark\Trait\JwtIssuerTrait;

class TransactionRequest implements RequestDtoInterface
{
    use JwtIssuerTrait;

    public function __construct(
        private readonly string $reference,
        private readonly int $nonce,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     reference: string,
     *     nonce: int,
     * }
     */
    public function asArray(): array
    {
        return [
            'reference' => $this->reference,
            'nonce'     => $this->nonce,
            ...$this->getIssuedAndExpirationTimes(),
        ];
    }
}
