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
    $invoiceRequest = new InvoiceRequest(
        walletId: '991D3240-4E74-44F8-991C-A6DA6D20F751',
        reference: 'uuid',
        amount: 10.00,
        nonce: time(),
        returnUrl: 'https://your-domain.io/return-url',
        callbackUrl: 'https://your-domain.io/calback-url',
    );

    $response = $pspark->createInvoice($invoiceRequest)->asArray();

    // Your business logic
} catch (ResponseValidationException $exception) {
    echo sprintf('Error message: %s. Error code: %s.', $exception->getMessage(), $exception->getCode());
}
```
