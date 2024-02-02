## Create Invoice request

```php
<?php

declare(strict_types=1);

use PsPark\Dto\InvoiceRequest;
use PsPark\Exception\ResponseValidationException;
use PsPark\PsPark;
use PsPark\Config;

require dirname(__DIR__) . '/vendor/autoload.php';

$pspark = new PsPark(new Config(jwtKey: 'jwt-key', apiKey: 'api-key'));

try {
    // '991D3240-4E74-44F8-991C-A6DA6D20F751' - Invoice wallet (for example: EUR)
    // 'DADC983B-6D9A-41C9-BC21-A17667CAF8D4' - Payment wallet ID of the payment wallet (which represents a payment currency,
    // for example USDT).

    // You can retrieve all wallet ids which you have created by using get-balances-request (see doc example). But take
    // into account that that get-balance-request will have a request rate limit, so you should temporarily cache this
    // data

    $details = new Details(escrowPayment: new EscrowPayment('DADC983B-6D9A-41C9-BC21-A17667CAF8D4'));

    $invoiceRequest = new InvoiceRequest(
        walletId: '991D3240-4E74-44F8-991C-A6DA6D20F751',
        reference: 'uuid',
        amount: 10.00,
        nonce: time(),
        returnUrl: 'https://your-domain.io/return-url',
        callbackUrl: 'https://your-domain.io/calback-url',
        details: $details,
    );

    $response = $pspark->createInvoice($invoiceRequest)->asArray();

    // Your business logic
} catch (ResponseValidationException $exception) {
    echo sprintf('Error message: %s. Error code: %s.', $exception->getMessage(), $exception->getCode());
}
```
