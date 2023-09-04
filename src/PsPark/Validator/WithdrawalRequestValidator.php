<?php

declare(strict_types=1);

namespace PsPark\Validator;

use PsPark\Validator\Constraint\ConstraintInterface;
use PsPark\Validator\Constraint\Required;

class WithdrawalRequestValidator extends AbstractValidator
{
    /**
     * @return ConstraintInterface[]
     */
    protected function getConstraints(): array
    {
        return [
            new Required('reference'),
            new Required('amount'),
            new Required('nonce'),
        ];
    }
}
