<?php

declare(strict_types=1);

namespace PsPark;

use PsPark\Handler\RequestHandlerInterface;
use PsPark\Handler\ResponseHandlerInterface;
use PsPark\Request\RequestInterface;
use PsPark\Request\ResponseInterface;
use PsPark\Transport\TransportInterface;

class ProxyClient implements ClientInterface
{
    public function __construct(
        private readonly TransportInterface $transport,
        private readonly RequestHandlerInterface $requestHandler,
        private readonly ResponseHandlerInterface $responseHandler
    ) {
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     * @throws Exception\ClientExceptionInterface
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $response = $this->transport->sendRequest($this->requestHandler->handle($request));

        return $this->responseHandler->handle($response);
    }
}
