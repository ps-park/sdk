<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\TestCase;
use PsPark\Dto\Details\Bank;
use PsPark\Dto\Details\BillingInfo;
use PsPark\Dto\Details\Crypto;
use PsPark\Dto\Details\Customer;
use PsPark\Dto\Details\EscrowPayment;

class DetailsTest extends TestCase
{
    public function testAsArray(): void
    {
        $userDataDto = new Details(
            customer: $customer = new Customer('First Name', 'Last Name'),
            billingInfo: $billingInfo = new BillingInfo('Address'),
            crypto: $crypto = new Crypto('memo'),
            bank: $bank = new Bank('Bank ID'),
            escrowPayment: $payment = new EscrowPayment('uuid'),
        );

        $this->assertEquals(
            array_filter([
                'customer'       => $customer->asArray(),
                'billing_info'   => $billingInfo->asArray(),
                'crypto'         => $crypto->asArray(),
                'bank'           => $bank->asArray(),
                'escrow_payment' => $payment->asArray(),
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
