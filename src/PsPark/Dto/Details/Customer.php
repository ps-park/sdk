<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class Customer implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $firstName = null,
        private readonly ?string $lastName = null,
        private readonly ?string $email = null,
        private readonly ?string $phone = null,
        private readonly ?string $customerId = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     first_name: string|null,
     *     last_name: string|null,
     *     email: string|null,
     *     phone: string|null,
     *     customer_id: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'first_name'  => $this->firstName,
            'last_name'   => $this->lastName,
            'email'       => $this->email,
            'phone'       => $this->phone,
            'customer_id' => $this->customerId,
        ]);
    }
}
