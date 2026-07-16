<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class Payway implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $pwid = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     pwid?: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'pwid' => $this->pwid,
        ]);
    }
}
