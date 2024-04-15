<?php

declare(strict_types=1);

namespace PsPark\Dto;

use PHPUnit\Framework\TestCase;
use PsPark\Dto\Details\Bank;
use PsPark\Dto\Details\BillingInfo;
use PsPark\Dto\Details\Crypto;
use PsPark\Dto\Details\Customer;
use PsPark\Dto\Details\EscrowPayment;
use PsPark\Dto\Details\Ui;
use PsPark\Dto\Details\WebData;

class DetailsTest extends TestCase
{
    public function testAsArray(): void
    {
        $userDataDto = new Details(
            customer: $customer = new Customer(
                firstName: 'First Name',
                lastName: 'Last Name',
                customerId: 'customer-id',
            ),
            billingInfo: $billingInfo = new BillingInfo('Address'),
            crypto: $crypto = new Crypto('memo'),
            bank: $bank = new Bank('Bank ID'),
            escrowPayment: $payment = new EscrowPayment('uuid'),
            webData: $webData = new WebData(userAgent: 'Firefox'),
            ui: $ui = new Ui('en'),
        );

        $this->assertEquals(
            array_filter([
                'customer'       => $customer->asArray(),
                'billing_info'   => $billingInfo->asArray(),
                'crypto'         => $crypto->asArray(),
                'bank'           => $bank->asArray(),
                'escrow_payment' => $payment->asArray(),
                'web_data'       => $webData->asArray(),
                'ui'             => $ui->asArray(),
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
