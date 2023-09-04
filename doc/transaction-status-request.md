## Request to check Transaction status

```php
<?php

declare(strict_types=1);

use PsPark\Dto\TransactionRequest;
use PsPark\Exception\ResponseValidationException;
use PsPark\PsPark;
use PsPark\Config;

require dirname(__DIR__) . '/vendor/autoload.php';

$pspark = new PsPark(new Config(jwtKey: 'jwt-key', apiKey: 'api-key'));

try {
    $transactionRequest = new TransactionRequest(reference: 'uuid', nonce: time());

    $result = $pspark->getTransactionStatus($transactionRequest)->asArray();

    // Your business logic
} catch (ResponseValidationException $exception) {
    echo sprintf('Error message: %s. Error code: %s.', $exception->getMessage(), $exception->getCode());
}
```
