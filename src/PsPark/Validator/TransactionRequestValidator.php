<?php

declare(strict_types=1);

namespace PsPark\Validator;

use PsPark\Validator\Constraint\Required;

class TransactionRequestValidator extends AbstractValidator
{
    protected function getConstraints(): array
    {
        return [
            new Required('reference'),
            new Required('nonce'),
        ];
    }
}
