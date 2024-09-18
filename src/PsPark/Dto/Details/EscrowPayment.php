<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class EscrowPayment implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $paymentWalletId = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     payment_wallet_id?: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'payment_wallet_id' => $this->paymentWalletId,
        ]);
    }
}
