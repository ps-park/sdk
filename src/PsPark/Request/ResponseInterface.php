<?php

declare(strict_types=1);

namespace PsPark\Request;

interface ResponseInterface
{
    public function getStatusCode(): int;

    public function getReasonPhrase(): string;

    /**
     * @return array|mixed|null
     */
    public function getInfo(string $type = null): mixed;

    public function getContent(): string;

    public function asArray(): array;
}
