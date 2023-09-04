<?php

declare(strict_types=1);

namespace PsPark\Request;

abstract class Request implements RequestInterface
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    private string $baseUrl = 'https://api.pspark.io';

    public function changeBaseUrl(string $url): self
    {
        $this->baseUrl = $url;

        return $this;
    }

    protected function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
