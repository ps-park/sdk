<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class Ui implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $language = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     language: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'language' => $this->language,
        ]);
    }
}
