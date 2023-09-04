<?php

declare(strict_types=1);

namespace PsPark\Request;

use CurlHandle;
use PsPark\Exception\JsonException;
use RuntimeException;

class HttpResponse implements ResponseInterface
{
    use ResponseTrait;

    private int|null $statusCode = null;

    private array|null $jsonDecodedData = null;

    public function __construct(
        private readonly string $result,
        private readonly CurlHandle $curlHandle,
    ) {
    }

    public function getStatusCode(): int
    {
        if ($this->statusCode === null) {
            $this->statusCode = (int) curl_getinfo($this->curlHandle, CURLINFO_RESPONSE_CODE);
        }

        return $this->statusCode;
    }

    public function getReasonPhrase(): string
    {
        return curl_error($this->curlHandle);
    }

    public function getInfo(string $type = null): mixed
    {
        $info = curl_getinfo($this->curlHandle);

        return $type !== null ? $info[$type] ?? null : $info;
    }

    public function getContent(): string
    {
        $this->checkStatusCode();

        return $this->result;
    }

    public function asArray(): array
    {
        $this->checkStatusCode();

        if ($this->result === '') {
            throw new JsonException('Bad response. The body can not be empty.');
        }

        if ($this->jsonDecodedData !== null) {
            return $this->jsonDecodedData;
        }


        $contentType = $this->headers['content-type'][0] ?? 'application/json';

        if (!preg_match('/\bjson\b/i', $contentType)) {
            throw new JsonException(
                sprintf(
                    'Got the "%s" response content-type, but expects JSON-compatible.',
                    $contentType
                )
            );
        }

        try {
            $decodedResult = json_decode($this->result, true, 512, JSON_BIGINT_AS_STRING);
        } catch (RuntimeException $e) {
            throw new JsonException($e->getMessage(), (int) $e->getCode());
        }

        if (!is_array($decodedResult)) {
            throw new JsonException('Can not decode JSON content to an array.');
        }

        $this->jsonDecodedData = $decodedResult;

        return $decodedResult;
    }
}
