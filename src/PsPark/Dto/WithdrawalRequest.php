<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PsPark\Trait\JwtIssuerTrait;

class WithdrawalRequest implements RequestDtoInterface
{
    use JwtIssuerTrait;

    public function __construct(
        public readonly string $walletId,
        private readonly string $reference,
        private readonly float $amount,
        private readonly string $account,
        private readonly int $nonce,
        private readonly Details|null $details = null,
        private readonly string|null $callbackUrl = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     reference: string,
     *     amount: float,
     *     account: string,
     *     nonce: int,
     *     details: array,
     *     callback_url: string|null
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'reference'    => $this->reference,
            'amount'       => $this->amount,
            'account'      => $this->account,
            'nonce'        => $this->nonce,
            'details'      => $this->details?->asArray(),
            'callback_url' => $this->callbackUrl,
            ...$this->getIssuedAndExpirationTimes(),
        ]);
    }
}
