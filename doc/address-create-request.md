## Create Address request

```php
<?php

declare(strict_types=1);

use PsPark\Dto\AddressRequest;
use PsPark\Exception\ResponseValidationException;
use PsPark\PsPark;
use PsPark\Config;

require dirname(__DIR__) . '/vendor/autoload.php';

$pspark = new PsPark(new Config(jwtKey: 'jwt-key', apiKey: 'api-key'));

try {
    $addressRequest = new AddressRequest(
        walletId: '991D3240-4E74-44F8-991C-A6DA6D20F751',
        reference: 'uuid',
        nonce: time()
    );


    $result = $pspark->createAddress($addressRequest)->asArray();

    // Your business logic
} catch (ResponseValidationException $exception) {
    echo sprintf('Error message: %s. Error code: %s.', $exception->getMessage(), $exception->getCode());
}
```
