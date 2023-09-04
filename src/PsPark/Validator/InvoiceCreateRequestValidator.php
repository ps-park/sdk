<?php

declare(strict_types=1);

namespace PsPark\Validator;

use PsPark\Validator\Constraint\Required;
use PsPark\Validator\Constraint\Url;

class InvoiceCreateRequestValidator extends AbstractValidator
{
    protected function getConstraints(): array
    {
        return [
            new Required('reference'),
            new Required('amount'),
            new Required('nonce'),
            new Url('return_url'),
        ];
    }
}
