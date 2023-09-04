<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PsPark\Dto\Details\Bank;
use PsPark\Dto\Details\BillingInfo;
use PsPark\Dto\Details\Crypto;
use PsPark\Dto\Details\Customer;

class Details implements RequestDtoInterface
{
    public function __construct(
        private readonly Customer|null $customer = null,
        private readonly BillingInfo|null $billingInfo = null,
        private readonly Crypto|null $crypto = null,
        private readonly Bank|null $bank = null,
    ) {
    }

    /**
     * @return string[]
     *
     * @psalm-return array{
     *     customer: array|null,
     *     billing_info: array|null,
     *     crypto: array|null,
     *     bank: array|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'customer'     => $this->customer?->asArray(),
            'billing_info' => $this->billingInfo?->asArray(),
            'crypto'       => $this->crypto?->asArray(),
            'bank'         => $this->bank?->asArray(),
        ]);
    }
}
