<?php

declare(strict_types=1);

namespace PsPark\Validator\Constraint;

use PsPark\Validator\ValidatorInterface;

interface ConstraintInterface
{
    public function __invoke(array $data, ValidatorInterface $validator): void;
}
