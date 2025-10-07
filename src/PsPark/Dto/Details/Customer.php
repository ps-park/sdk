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
        private readonly ?string $nationalId = null,
        private readonly ?string $taxpayerIdentificationNumber = null,
        private readonly ?string $documentType = null,
        private readonly ?string $birthdate = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     first_name?: string|null,
     *     last_name?: string|null,
     *     email?: string|null,
     *     phone?: string|null,
     *     customer_id?: string|null,
     *     national_id?: string|null,
     *     taxpayer_identification_number?: string|null,
     *     document_type?: string|null,
     *     birthdate?: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter([
            'first_name'                     => $this->firstName,
            'last_name'                      => $this->lastName,
            'email'                          => $this->email,
            'phone'                          => $this->phone,
            'customer_id'                    => $this->customerId,
            'national_id'                    => $this->nationalId,
            'taxpayer_identification_number' => $this->taxpayerIdentificationNumber,
            'document_type'                  => $this->documentType,
            'birthdate'                      => $this->birthdate,
        ]);
    }
}
