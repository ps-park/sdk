<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PsPark\Trait\JwtIssuerTrait;

class InvoiceRequest implements RequestDtoInterface
{
    use JwtIssuerTrait;

    public function __construct(
        public readonly string $walletId,
        private readonly string $reference,
        private readonly float $amount,
        private readonly int $nonce,
        private readonly Details|null $details = null,
        private readonly string|null $title = null,
        private readonly string|null $description = null,
        private readonly string|null $callbackUrl = null,
        private readonly string|null $returnUrl = null,
        private readonly int|null $timeLimit = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     reference: string,
     *     amount: float,
     *     nonce: int,
     *     details: array,
     *     title: string|null,
     *     description: string|null,
     *     callback_url: string|null,
     *     limit_minute: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'reference'    => $this->reference,
            'amount'       => $this->amount,
            'nonce'        => $this->nonce,
            'details'      => $this->details?->asArray(),
            'title'        => $this->title,
            'description'  => $this->description,
            'callback_url' => $this->callbackUrl,
            'return_url'   => $this->returnUrl,
            'limit_minute' => $this->timeLimit,
            ...$this->getIssuedAndExpirationTimes(),
        ]);
    }
}
