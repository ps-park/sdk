<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PsPark\Dto\Details\Bank;
use PsPark\Dto\Details\BillingInfo;
use PsPark\Dto\Details\Crypto;
use PsPark\Dto\Details\Customer;
use PsPark\Trait\JwtIssuerTrait;

class WithdrawalRequestTest extends TestCase
{
    use JwtIssuerTrait;

    private Details|MockObject $detailsDtoMock;

    protected function setUp(): void
    {
        $this->detailsDtoMock = $this->getMockBuilder(Details::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @param array $outcomeData
     *
     * @dataProvider withdrawalDataProvider
     *
     * @return void
     */
    public function testAsArray(array $outcomeData): void
    {
        $this->detailsDtoMock
            ->method('asArray')
            ->willReturn($outcomeData['details'] ?? []);

        $details = null ;

        if (array_key_exists('details', $outcomeData)) {
            $data = $outcomeData['details'];
            $customer    = $data['customer'] ?? [];
            $billingInfo = $data['billing_info'] ?? [];
            $crypto      = $data['crypto'] ?? [];
            $bank        = $data['bank'] ?? [];
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
                    country: $billingInfo['country'],
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
                ),
            );
        }

        $outcomeSendDto = new WithdrawalRequest(
            walletId: '79CDA5A3-C688-4996-8D20-3EDDF4E6B70B',
            reference: $outcomeData['reference'],
            amount: $outcomeData['amount'],
            account: $outcomeData['account'],
            nonce: $outcomeData['nonce'],
            details: $details,
            callbackUrl: $outcomeData['callback_url'],
        );

        $this->assertEquals(
            [...array_filter($outcomeData), ...$this->getIssuedAndExpirationTimes()],
            $outcomeSendDto->asArray()
        );
    }

    /**
     * @return array[][]
     */
    public function withdrawalDataProvider(): array
    {
        return [
            'full filled data'      => [
                [
                    'reference'    => 'uuid-1',
                    'amount'       => 100.00,
                    'account'      => '4111111111111111',
                    'callback_url' => 'http://test-callback-url.com',
                    'nonce'        => 123456,
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
                            'id'   => 'Bank ID',
                            'name' => 'Bank Name'
                        ],
                    ],
                ],
            ],
            'partially filled data' => [
                [
                    'reference'    => 'uuid-1',
                    'amount'       => 100.00,
                    'account'      => '4111111111111111',
                    'callback_url' => 'http://test-callback-url.com',
                    'nonce'        => 123456,
                    'details'      => [
                        'billing_info' => [
                            'address'      => 'Address',
                            'country_code' => 'Country Code',
                            'country'      => 'Country',
                        ],
                    ],
                ],
            ],
            'empty details' => [
                [
                    'reference'    => 'uuid-1',
                    'amount'       => 100.00,
                    'account'      => '4111111111111111',
                    'callback_url' => 'http://test-callback-url.com',
                    'nonce'        => 123456,
                ],
            ],
        ];
    }
}
