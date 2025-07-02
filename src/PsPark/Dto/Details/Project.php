<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class Project implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $url = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     url?: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'url' => $this->url,
        ]);
    }
}
