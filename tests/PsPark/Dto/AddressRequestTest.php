<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\TestCase;
use PsPark\Trait\JwtIssuerTrait;

class AddressRequestTest extends TestCase
{
    use JwtIssuerTrait;

    /**
     * @param array $addressData
     *
     * @dataProvider addressDtoDataProvider
     */
    public function testAsArray(array $addressData): void
    {
        $addressCreateDto = new AddressRequest(
            walletId: '79CDA5A3-C688-4996-8D20-3EDDF4E6B70B',
            reference: $addressData['reference'],
            nonce: $addressData['nonce'],
            title: $addressData['title'],
            description: $addressData['description'],
            timeLimit: $addressData['limit_minute'],
            callbackUrl: $addressData['callback_url']
        );

        $this->assertEquals(
            [...array_filter($addressData), ...$this->getIssuedAndExpirationTimes()],
            $addressCreateDto->asArray()
        );
    }

    /**
     * @return array[][]
     */
    public function addressDtoDataProvider(): array
    {
        return [
            'full filled Dto'      => [
                [
                    'reference'        => 'uuid',
                    'nonce'            => time(),
                    'description'      => 'Description.',
                    'limit_minute'     => 6,
                    'title'            => 'Tile',
                    'callback_url'     => 'https://callback-url.com',
                ],
            ],
            'partially_filled Dto' => [
                [
                    'reference'        => 'uuid',
                    'nonce'            => time(),
                    'title'            => null,
                    'description'      => null,
                    'limit_minute'     => null,
                    'callback_url'     => null,
                ],
            ],
        ];
    }
}
