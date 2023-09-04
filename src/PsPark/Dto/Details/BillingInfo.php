<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class BillingInfo implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $address,
        private readonly ?string $countryCode = null,
        private readonly ?string $country = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     'address': string|null,
     *     'country_code': string|null,
     *     'country': string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'address'      => $this->address,
            'country_code' => $this->countryCode,
            'country'      => $this->country,
        ]);
    }
}
