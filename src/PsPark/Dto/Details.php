<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PsPark\Dto\Details\Bank;
use PsPark\Dto\Details\BillingInfo;
use PsPark\Dto\Details\CardData;
use PsPark\Dto\Details\Crypto;
use PsPark\Dto\Details\Customer;
use PsPark\Dto\Details\EscrowPayment;
use PsPark\Dto\Details\Project;
use PsPark\Dto\Details\Ui;
use PsPark\Dto\Details\WebData;

class Details implements RequestDtoInterface
{
    public function __construct(
        private readonly Customer|null $customer = null,
        private readonly BillingInfo|null $billingInfo = null,
        private readonly Crypto|null $crypto = null,
        private readonly Bank|null $bank = null,
        private readonly EscrowPayment|null $escrowPayment = null,
        private readonly Ui|null $ui = null,
        private readonly WebData|null $webData = null,
        private readonly CardData|null $cardData = null,
        private readonly Project|null $project = null,
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
     *     escrow_payment: array|null,
     *     ui: array|null,
     *     web_data: array|null,
     *     card_data: array|null,
     *     project: array|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'customer'       => $this->customer?->asArray(),
            'billing_info'   => $this->billingInfo?->asArray(),
            'crypto'         => $this->crypto?->asArray(),
            'bank'           => $this->bank?->asArray(),
            'escrow_payment' => $this->escrowPayment?->asArray(),
            'ui'             => $this->ui?->asArray(),
            'web_data'       => $this->webData?->asArray(),
            'card_data'      => $this->cardData?->asArray(),
            'project'        => $this->project?->asArray(),
        ]);
    }
}
