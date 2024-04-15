<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class CardData implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $expMonth = null,
        private readonly ?string $expYear = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     exp_month: string|null,
     *     exp_year: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'exp_month' => $this->expMonth,
            'exp_year'  => $this->expYear,
        ]);
    }
}
