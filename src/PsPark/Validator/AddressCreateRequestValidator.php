<?php

declare(strict_types=1);

namespace PsPark\Validator;

use PsPark\Validator\Constraint\Required;
use PsPark\Validator\Constraint\Url;

class AddressCreateRequestValidator extends AbstractValidator
{
    protected function getConstraints(): array
    {
        return [
            new Required('reference'),
            new Required('nonce'),
            new Url('callback_url'),
        ];
    }
}
