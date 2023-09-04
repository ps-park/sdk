<?php

declare(strict_types=1);

namespace PsPark\Validator;

use PsPark\Request\RequestInterface;
use PsPark\Validator\Constraint\ConstraintInterface;

abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var string[]
     */
    private array $errors = [];

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    public function validate(RequestInterface $request): void
    {
        foreach ($this->getConstraints() as $constraint) {
            $constraint($request->getBody(), $this);
        }
    }

    /**
     * @return ConstraintInterface[]
     */
    abstract protected function getConstraints(): array;
}
