<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class Bank implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $id = null,
        private readonly ?string $name = null,
        private readonly ?string $account = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     id?: string|null,
     *     name?: string|null,
     *     account?: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'id'      => $this->id,
            'name'    => $this->name,
            'account' => $this->account,
        ]);
    }
}
