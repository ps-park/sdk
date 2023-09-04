<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\TestCase;
use PsPark\Dto\Details\Bank;
use PsPark\Dto\Details\BillingInfo;
use PsPark\Dto\Details\Crypto;
use PsPark\Dto\Details\Customer;

class DetailsTest extends TestCase
{
    public function testAsArray(): void
    {
        $userDataDto = new Details(
            customer: $customer = new Customer('First Name', 'Last Name'),
            billingInfo: $billingInfo = new BillingInfo('Address'),
            crypto: $crypto = new Crypto('memo'),
            bank: $bank = new Bank('Bank ID'),
        );

        $this->assertEquals(
            array_filter([
                'customer'     => $customer->asArray(),
                'billing_info' => $billingInfo->asArray(),
                'crypto'       => $crypto->asArray(),
                'bank'         => $bank->asArray(),
            ]),
            $userDataDto->asArray()
        );
    }

    public function testWhenDetailsIsEmpty(): void
    {
        $userDataDto = new Details();

        $this->assertEmpty($userDataDto->asArray());
    }
}
