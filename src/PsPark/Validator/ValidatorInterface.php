<?php

declare(strict_types=1);

namespace PsPark\Validator;

use PsPark\Request\RequestInterface;

interface ValidatorInterface
{
    public function hasErrors(): bool;

    /**
     * @return string[]
     */
    public function getErrors(): array;

    public function addError(string $message): void;

    public function validate(RequestInterface $request): void;
}
