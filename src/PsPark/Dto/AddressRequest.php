<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PsPark\Trait\JwtIssuerTrait;

class AddressRequest implements RequestDtoInterface
{
    use JwtIssuerTrait;

    public function __construct(
        public readonly string $walletId,
        private readonly string $reference,
        private readonly int $nonce,
        private readonly string|null $title = null,
        private readonly string|null $description = null,
        private readonly int|null $timeLimit = null,
        private readonly string|null $callbackUrl = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     reference: string,
     *     nonce: int,
     *     title: string|null,
     *     description: string|null,
     *     limit_minute: int|null,
     *     callback_url: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'reference'    => $this->reference,
            'nonce'        => $this->nonce,
            'title'        => $this->title,
            'description'  => $this->description,
            'limit_minute' => $this->timeLimit,
            'callback_url' => $this->callbackUrl,
            ...$this->getIssuedAndExpirationTimes(),
        ]);
    }
}
