<?php

declare(strict_types=1);

namespace PsPark\Validator;

use PsPark\Validator\Constraint\Required;

class BalanceRequestValidator extends AbstractValidator
{
    protected function getConstraints(): array
    {
        return [
            new Required('nonce'),
        ];
    }
}
