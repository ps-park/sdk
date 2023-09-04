## Create withdrawal request

```php
<?php

declare(strict_types=1);

use PsPark\Config;
use PsPark\Dto\Details;
use PsPark\Dto\Details\Bank;
use PsPark\Dto\Details\Customer;
use PsPark\Dto\WithdrawalRequest;
use PsPark\Exception\ResponseValidationException;
use PsPark\PsPark;

require dirname(__DIR__) . '/vendor/autoload.php';

$pspark = new PsPark(new Config(jwtKey: 'jwt-key', apiKey: 'api-key'));

try {
    $withdrawalRequest = new WithdrawalRequest(
        walletId: '991D3240-4E74-44F8-991C-A6DA6D20F751',
        reference: 'uuid',
        amount: 100.00,
        account: 4111111111111111,
        nonce: time(),
        details: new Details(
            customer: new Customer(
                firstName: 'First Name',
            ),
            bank: new Bank(id: 'Bank ID', name: "Bank Name"),
        ),
    );

    $result = $pspark->createWithdrawal($withdrawalRequest)->asArray();

    // Your business logic
} catch (ResponseValidationException $exception) {
    echo sprintf('Error message: %s. Error code: %s.', $exception->getMessage(), $exception->getCode());
}
```
