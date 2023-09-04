<?php

declare(strict_types=1);

namespace PsPark\Request;

use PsPark\Enum\ApiUrl;
use PsPark\Enum\ApiVersion;

class HttpRequest extends Request
{
    private array $headers = [
        'Accept: application/json',
    ];

    private array $options = [
        CURLOPT_USERAGENT      => 'PsPark-PHP-SDK',
        CURLOPT_HEADER         => false,
        CURLINFO_HEADER_OUT    => true,
        CURLOPT_RETURNTRANSFER => true,
    ];

    private ApiUrl|null $url = null;

    private string $method = Request::METHOD_POST;

    private array $bodyData = [];

    private array $urlParams = [];

    public function withHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function withHeader(string $name, mixed $value): self
    {
        $this->headers[] = "$name: $value";

        return $this;
    }

    public function hasHeader(string $name): bool
    {
        return in_array($name, $this->headers, true);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function withOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function withUrl(ApiUrl $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function addUrlParams(string $name, mixed $value): self
    {
        $this->urlParams[":$name"] = $value;

        return $this;
    }

    public function getFullUrl(): string
    {
        return sprintf(
            '%s/%s/%s',
            $this->getBaseUrl(),
            ApiVersion::getDefault()->value,
            $this->resolveUrlParams($this->getUrl(), $this->urlParams),
        );
    }

    public function getUrl(): ApiUrl|null
    {
        return $this->url;
    }

    public function withMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function withBody(array $data): self
    {
        $this->bodyData = $data;

        return $this;
    }

    public function getBody(): array
    {
        return $this->bodyData;
    }

    public function getBodyAsJson(): string
    {
        return json_encode($this->getBody(), JSON_THROW_ON_ERROR);
    }

    private function resolveUrlParams(ApiUrl $apiUrl, array $urlParams): string
    {
        if (count($urlParams) > 0) {
            return strtr($apiUrl->value, $urlParams);
        }

        return $apiUrl->value;
    }
}
