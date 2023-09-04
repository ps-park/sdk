<?php

declare(strict_types=1);

namespace PsPark\Validator\Constraint;

use PsPark\Validator\ValidatorInterface;

class Url implements ConstraintInterface
{
    public function __construct(
        private readonly string $attributeName,
    ) {
    }

    public function __invoke(array $data, ValidatorInterface $validator): void
    {
        if (array_key_exists($this->attributeName, $data) && !filter_var($data[$this->attributeName], FILTER_VALIDATE_URL)) {
            $validator->addError(sprintf('The "%s" parameter is not a valid url!', $this->attributeName));
        }
    }
}
