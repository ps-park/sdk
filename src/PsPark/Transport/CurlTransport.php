<?php

declare(strict_types=1);

namespace PsPark\Transport;

use CurlHandle;
use PsPark\ConfigInterface;
use PsPark\Exception\ConfigurationException;
use PsPark\Request\HttpResponse;
use PsPark\Request\RequestInterface;
use PsPark\Request\ResponseInterface;

class CurlTransport implements TransportInterface
{
    private CurlHandle|null $curl;

    public function __construct(
        private readonly ConfigInterface $requestConfig,
    ) {
        if (!function_exists("curl_init")) {
            throw new ConfigurationException("Curl module is not available on this system.");
        }

        $this->curl = curl_init();
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        curl_setopt_array($this->curl, array_replace($this->requestConfig->getCurlOptions(), $request->getOptions()));
        curl_setopt($this->curl, CURLOPT_URL, $request->getFullUrl());
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $request->getHeaders());
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($request->getBody(), JSON_THROW_ON_ERROR));

        if ($this->requestConfig->isDebugMode() && getenv('TYPE_ENV') !== 'production') {
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        }

        $result = curl_exec($this->curl);

        return new HttpResponse((is_string($result)) ? $result : '', $this->curl);
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }
}
