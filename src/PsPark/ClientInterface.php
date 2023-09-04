<?php

declare(strict_types=1);

namespace PsPark;

use PsPark\Exception\ClientExceptionInterface;
use PsPark\Request\RequestInterface;
use PsPark\Request\ResponseInterface;

interface ClientInterface
{
    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws ClientExceptionInterface If an error happens while processing the request.
     */
    public function sendRequest(RequestInterface $request): ResponseInterface;
}
