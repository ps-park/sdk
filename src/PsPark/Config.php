<?php

declare(strict_types=1);

namespace PsPark;

final class Config implements ConfigInterface
{
    public const CUSTOM_BASE_URL_OPTION = 'custom_base_url';

    private bool $isDebugMode = false;

    public function __construct(
        private readonly string $jwtKey,
        private readonly string $apiKey,
        private readonly array $curlOptions = [],
        private readonly array $options = [],
    ) {
    }

    public function getJwtKey(): string
    {
        return $this->jwtKey;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getCurlOptions(): array
    {
        return $this->curlOptions;
    }

    public function isDebugMode(): bool
    {
        return $this->isDebugMode;
    }

    public function enableDebugMode(): self
    {
        $this->isDebugMode = true;

        return $this;
    }

    public function getOptionByKey(string $key): mixed
    {
        return $this->options[$key] ?? null;
    }

    public function hasOptions(string $key): bool
    {
        return array_key_exists($key, $this->options);
    }
}
