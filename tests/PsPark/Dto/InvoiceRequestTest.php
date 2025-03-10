<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\TestCase;
use PsPark\Dto\Details\Bank;
use PsPark\Dto\Details\BillingInfo;
use PsPark\Dto\Details\CardData;
use PsPark\Dto\Details\Crypto;
use PsPark\Dto\Details\Customer;
use PsPark\Dto\Details\WebData;
use PsPark\Trait\JwtIssuerTrait;

/** @package PsPark\Dto */
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
            $cardData    = $invoiceData['details']['card_data'] ?? [];
            $webData     = $invoiceData['details']['web_data'] ?? [];

            $details = new Details(
                customer: new Customer(
                    firstName: $customer['first_name'] ?? null,
                    lastName: $customer['last_name'] ?? null,
                    email: $customer['email'] ?? null,
                    phone: $customer['phone'] ?? null,
                    nationalId: $customer['national_id'] ?? null,
                    taxpayerIdentificationNumber: $customer['taxpayer_identification_number'] ?? null,
                    birthdate: $customer['birthdate'] ?? null,
                ),
                billingInfo: new BillingInfo(
                    address: $billingInfo['address'] ?? null,
                    countryCode: $billingInfo['country_code'] ?? null,
                    country: $billingInfo['country'] ?? null,
                    city: $billingInfo['city'] ?? null,
                    postCode: $billingInfo['post_code'] ?? null,
                    region: $billingInfo['region'] ?? null,
                    state: $billingInfo['state'] ?? null,
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
                            'birthdate'                      => '1985-07-24',
                        ],
                        'billing_info' => [
                            'address'         => 'Address',
                            'country_code'    => 'IND',
                            'country'         => 'India',
                            'city'            => 'Mumbai',
                            'post_code'       => 'Country',
                            'region'          => 'Maharashtra',
                            'state'           => 'ON',
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
