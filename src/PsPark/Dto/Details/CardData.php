<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class CardData implements RequestDtoInterface
{
    public function __construct(
        private readonly ?int $number = null,
        private readonly ?string $expMonth = null,
        private readonly ?string $expYear = null,
        private readonly string|int|null $cvv = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     number?: int|null,
     *     exp_month?: string|null,
     *     exp_year?: string|null,
     *     cvv?: int|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'number'    => $this->number,
            'exp_month' => $this->expMonth,
            'exp_year'  => $this->expYear,
            'cvv'       => $this->cvv,
        ]);
    }
}
