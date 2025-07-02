<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PsPark\Dto\Details\Bank;
use PsPark\Dto\Details\BillingInfo;
use PsPark\Dto\Details\CardData;
use PsPark\Dto\Details\Crypto;
use PsPark\Dto\Details\Customer;
use PsPark\Dto\Details\Project;
use PsPark\Dto\Details\WebData;
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
            $cardData    = $data['card_data'] ?? [];
            $webData     = $data['web_data'] ?? [];
            $project     = $data['project'] ?? [];

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
                    bicCode: $bank['bic_code'] ?? null,
                ),
                cardData: new CardData(
                    number: $cardData['number'] ?? null,
                    expMonth: $cardData['exp_month'] ?? null,
                    expYear: $cardData['exp_year'] ?? null,
                    cvv: $cardData['cvv'] ?? null,
                ),
                webData: new WebData(
                    ip: $webData['ip'] ?? null,
                    userAgent: $webData['user_agent'] ?? null,
                    browserColorDepth: $webData['browser_color_depth'] ?? null,
                    browserLanguage: $webData['browser_language'] ?? null,
                    browserScreenHeight: $webData['browser_screen_height'] ?? null,
                    browserScreenWidth: $webData['browser_screen_width'] ?? null,
                    browserTimezone: $webData['browser_timezone'] ?? null,
                    browserTimezoneOffset: $webData['browser_timezone_offset'] ?? null,
                    browserJavaEnabled: $webData['browser_java_enabled'] ?? null,
                    browserJavaScriptEnabled: $webData['browser_java_script_enabled'] ?? null,
                    browserAcceptHeader: $webData['browser_accept_header'] ?? null,
                ),
                project: new Project($project['url'] ?? null),
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
                            'id'       => 'Bank ID',
                            'name'     => 'Bank Name',
                            'bic_code' => 'AAAA-BB-CC-123',
                        ],
                        'card_data' => [
                            'number'    => 4111111111111111,
                            'exp_month' => '12',
                            'exp_year'  => '2050',
                            'cvv'       => 123,
                        ],
                        'web_data' => [
                            'ip'                          => '127.0.0.1',
                            'user_agent'                  => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36',
                            'browser_color_depth'         => 30,
                            'browser_language'            => 'en-GB,en-US;q=0.9,en;q=0.8',
                            'browser_screen_height'       => 1080,
                            'browser_screen_width'        => 1920,
                            'browser_timezone'            => 'Europe/Kiev',
                            'browser_timezone_offset'     => -120,
                            'browser_java_enabled'        => false,
                            'browser_java_script_enabled' => true,
                            'browser_accept_header'       => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,/;q=0.8',
                        ],
                        'project' => [
                            'url' => 'https://project-url.com',
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
