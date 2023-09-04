## Request to check balance

```php
<?php

declare(strict_types=1);

use PsPark\Dto\BalancesRequest;
use PsPark\Exception\ResponseValidationException;
use PsPark\PsPark;
use PsPark\Config;

require dirname(__DIR__) . '/vendor/autoload.php';

$pspark = new PsPark(new Config(jwtKey: 'jwt-key', apiKey: 'pai-key'));

try {
    $result = $pspark->getBalances(new BalancesRequest(nonce: time()))->asArray();

    // Your business logic
} catch (ResponseValidationException $exception) {
    echo sprintf('Error message: %s. Error code: %s.', $exception->getMessage(), $exception->getCode());
}
```
