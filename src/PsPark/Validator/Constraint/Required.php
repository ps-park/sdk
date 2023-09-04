<?php

declare(strict_types=1);

namespace PsPark\Validator\Constraint;

use PsPark\Validator\ValidatorInterface;

class Required implements ConstraintInterface
{
    public function __construct(
        private readonly string $attributeName,
    ) {
    }

    public function __invoke(array $data, ValidatorInterface $validator): void
    {
        if (
            !array_key_exists($this->attributeName, $data)
            || $data[$this->attributeName] === null
            || (is_string($data[$this->attributeName]) && trim($data[$this->attributeName]) === '')
        ) {
            $validator->addError(sprintf('The "%s" parameter is required!', $this->attributeName));
        }
    }
}
