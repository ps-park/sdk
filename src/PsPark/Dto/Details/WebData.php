<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class WebData implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $ip = null,
        private readonly ?string $userAgent = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     ip: string|null,
     *     user_agent: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'ip'         => $this->ip,
            'user_agent' => $this->userAgent,
        ]);
    }
}
