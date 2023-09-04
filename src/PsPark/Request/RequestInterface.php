<?php

declare(strict_types=1);

namespace PsPark\Request;

use PsPark\Enum\ApiUrl;

interface RequestInterface
{
    public function withHeaders(array $headers): void;

    public function withHeader(string $name, mixed $value): self;

    public function hasHeader(string $name): bool;

    public function getHeaders(): array;

    public function withOptions(array $options): self;

    public function getOptions(): array;

    public function changeBaseUrl(string $url): self;

    public function withUrl(ApiUrl $url): self;

    public function addUrlParams(string $name, mixed $value): self;

    public function getUrl(): ApiUrl|null;

    public function getFullUrl(): string;

    public function withMethod(string $method): self;

    public function getMethod(): string;

    public function withBody(array $data): self;

    public function getBody(): array;

    public function getBodyAsJson(): string;
}
