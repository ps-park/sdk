<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\TestCase;
use PsPark\Dto\Details\Bank;
use PsPark\Dto\Details\BillingInfo;
use PsPark\Dto\Details\Crypto;
use PsPark\Dto\Details\Customer;
use PsPark\Trait\JwtIssuerTrait;

class InvoiceRequestTest extends TestCase
{
    use JwtIssuerTrait;

    /**
     * @param array $invoiceData
     *
     * @dataProvider invoiceDtoDataProvider
     */
    public function testAsArray(array $invoiceData): void
    {
        $details = null;

        if (array_key_exists('details', $invoiceData)) {
            $customer    = $invoiceData['details']['customer'] ?? [];
            $billingInfo = $invoiceData['details']['billing_info'] ?? [];
            $crypto      = $invoiceData['details']['crypto'] ?? [];
            $bank        = $invoiceData['details']['bank'] ?? [];

            $details = new Details(
                customer: new Customer(
                    firstName: $customer['first_name'] ?? null,
                    lastName: $customer['last_name'] ?? null,
                    email: $customer['email'] ?? null,
                    phone: $customer['phone'] ?? null,
                    nationalId: $customer['national_id'] ?? null,
                    taxpayerIdentificationNumber: $customer['taxpayer_identification_number'] ?? null,
                ),
                billingInfo: new BillingInfo(
                    address: $billingInfo['address'] ?? null,
                    countryCode: $billingInfo['country_code'] ?? null,
                    country: $billingInfo['country'] ?? null,
                    city: $billingInfo['city'] ?? null,
                    postCode: $billingInfo['post_code'] ?? null,
                    region: $billingInfo['region'] ?? null,
                    paymentPurpose: $billingInfo['payment_purpose'] ?? null,
                    street: $billingInfo['street'] ?? null,
                ),
                crypto: new Crypto(memo: $crypto['memo'] ?? null),
                bank: new Bank(
                    id: $bank['id'] ?? null,
                    name: $bank['name'] ?? null,
                    bicCode: $bank['bic_code'] ?? null,
                ),
            );
        }

        $invoiceCreateDto = new InvoiceRequest(
            walletId: '79CDA5A3-C688-4996-8D20-3EDDF4E6B70B',
            reference: $invoiceData['reference'],
            amount: $invoiceData['amount'],
            nonce: $invoiceData['nonce'],
            details: $details,
            title: $invoiceData['title'] ?? null,
            description: $invoiceData['description'] ?? null,
            callbackUrl: $invoiceData['callback_url'] ?? null,
            returnUrl: $invoiceData['return_url'] ?? null,
            timeLimit: $invoiceData['limit_minute'] ?? null,
        );

        $this->assertEquals(
            [...array_filter($invoiceData), ...$this->getIssuedAndExpirationTimes()],
            $invoiceCreateDto->asArray()
        );
    }

    /**
     * @return array[][]
     */
    public function invoiceDtoDataProvider(): array
    {
        return [
            'full filled Dto'      => [
                [
                    'reference'    => 'uuid-1',
                    'amount'       => 200.00,
                    'callback_url' => 'https://callback-url.com',
                    'return_url'   => 'https://return-url.com',
                    'limit_minute' => 10,
                    'nonce'        => time(),
                    'title'        => 'Title',
                    'description'  => 'Description',
                    'details'      => [
                        'customer' => [
                            'first_name'                     => 'First Name',
                            'last_name'                      => 'Last Name',
                            'email'                          => 'email',
                            'phone'                          => 'phone',
                            'national_id'                    => '1234566789',
                            'taxpayer_identification_number' => '23456-33224',
                        ],
                        'billing_info' => [
                            'address'         => 'Address',
                            'country_code'    => 'IND',
                            'country'         => 'India',
                            'city'            => 'Mumbai',
                            'post_code'       => 'Country',
                            'region'          => 'Maharashtra',
                            'payment_purpose' => 'Payment purpose',
                            'street'          => 'Baker Street',
                        ],
                        'crypto'       => [
                            'memo' => 'memo'
                        ],
                        'bank'         => [
                            'id'       => 'Bank ID',
                            'name'     => 'Bank Name',
                            'bic_code' => 'AAAA-BB-CC-123',
                        ],
                    ],
                ],
            ],
            'partially_filled Dto' => [
                [
                    'reference' => 'uuid-1',
                    'amount'    => 200.00,
                    'nonce'     => time(),
                    'details'   => [
                        'customer' => [
                            'first_name' => 'First Name',
                            'last_name'  => 'Last Name',
                            'email'      => 'email',
                            'phone'      => 'phone',
                        ],
                        'bank'     => [
                            'id'   => 'Bank ID',
                            'name' => 'Bank Name'
                        ],
                    ],
                ],
            ],
            'empty details' => [
                [
                    'reference' => 'uuid-1',
                    'amount'    => 200.00,
                    'nonce'     => time(),
                ],
            ],
        ];
    }
}
