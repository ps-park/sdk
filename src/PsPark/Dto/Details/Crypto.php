<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class Crypto implements RequestDtoInterface
{
    public function __construct(
        private readonly string|int|null $memo = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     memo: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'memo' => $this->memo,
        ]);
    }
}
