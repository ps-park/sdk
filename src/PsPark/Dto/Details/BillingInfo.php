<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class BillingInfo implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $address = null,
        private readonly ?string $countryCode = null,
        private readonly ?string $country = null,
        private readonly ?string $city = null,
        private readonly ?string $postCode = null,
        private readonly ?string $region = null,
        private readonly ?string $paymentPurpose = null,
        private readonly ?string $street = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     address?: string|null,
     *     country_code?: string|null,
     *     country?: string|null,
     *     city?: string|null,
     *     post_code?: string|null,
     *     region?: string|null,
     *     payment_purpose?: string|null,
     *     street?: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'address'         => $this->address,
            'country_code'    => $this->countryCode,
            'country'         => $this->country,
            'city'            => $this->city,
            'post_code'       => $this->postCode,
            'region'          => $this->region,
            'payment_purpose' => $this->paymentPurpose,
            'street'          => $this->street,
        ]);
    }
}
