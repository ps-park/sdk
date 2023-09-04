<?php

declare(strict_types=1);

namespace PsPark\Middleware\Request;

use Firebase\JWT\JWT;
use PsPark\Handler\RequestHandlerInterface;
use PsPark\Request\RequestInterface;
use PsPark\Middleware\RequestMiddlewareInterface;

class RequestSignerMiddleware implements RequestMiddlewareInterface
{
    public function __construct(
        private readonly string $apiKey,
        private readonly string $jwtKey,
    ) {
    }

    public function handle(RequestInterface $request, RequestHandlerInterface $handler): RequestInterface
    {
        $request
            ->withHeader('X-API-Key', $this->apiKey)
            ->withHeader('Authorization', "Bearer {$this->sign($request)}");

        return $handler->handle($request);
    }

    private function sign(RequestInterface $request): string
    {
        return JWT::encode($request->getBody(), $this->jwtKey, 'RS256');
    }
}
