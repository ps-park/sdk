<?php

declare(strict_types=1);

namespace PsPark\Request;

use PsPark\Config;
use PsPark\Enum\ApiUrl;

class ConfigurableHttpRequest extends Request
{
    public function __construct(
        private readonly RequestInterface $httpRequest,
        private readonly Config $config,
    ) {
    }

    public function withHeaders(array $headers): void
    {
        $this->httpRequest->withHeaders($headers);
    }

    public function withHeader(string $name, mixed $value): self
    {
        $this->httpRequest->withHeader($name, $value);

        return $this;
    }

    public function hasHeader(string $name): bool
    {
        return $this->httpRequest->hasHeader($name);
    }

    public function getHeaders(): array
    {
        return $this->httpRequest->getHeaders();
    }

    public function withOptions(array $options): self
    {
        $this->httpRequest->withOptions($options);

        return $this;
    }

    public function getOptions(): array
    {
        return $this->httpRequest->getOptions();
    }

    public function withUrl(ApiUrl $url): self
    {
        $this->httpRequest->withUrl($url);

        return $this;
    }

    public function addUrlParams(string $name, mixed $value): self
    {
        $this->httpRequest->addUrlParams($name, $value);

        return $this;
    }

    public function getUrl(): ApiUrl|null
    {
        return $this->httpRequest->getUrl();
    }

    public function getFullUrl(): string
    {
        $this->httpRequest->changeBaseUrl($this->getBaseUrl());

        return $this->httpRequest->getFullUrl();
    }

    public function withMethod(string $method): self
    {
        $this->httpRequest->withMethod($method);

        return $this;
    }

    public function getMethod(): string
    {
        return $this->httpRequest->getMethod();
    }

    public function withBody(array $data): self
    {
        $this->httpRequest->withBody($data);

        return $this;
    }

    public function getBody(): array
    {
        return $this->httpRequest->getBody();
    }

    public function getBodyAsJson(): string
    {
        return $this->httpRequest->getBodyAsJson();
    }

    protected function getBaseUrl(): string
    {
        if ($this->config->isDebugMode() && $this->config->hasOptions(Config::CUSTOM_BASE_URL_OPTION)) {
            return $this->config->getOptionByKey(Config::CUSTOM_BASE_URL_OPTION);
        }

        return parent::getBaseUrl();
    }
}
