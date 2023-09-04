<?php

declare(strict_types=1);

namespace PsPark\Handler;

use PsPark\Request\ResponseInterface;
use PsPark\Middleware\ResponseMiddlewareInterface;

class ResponseHandler implements ResponseHandlerInterface
{
    /**
     * @var ResponseMiddlewareInterface[]
     */
    private array $middlewares;

    /**
     * @param ResponseMiddlewareInterface[] $middlewares
     */
    public function __construct(array $middlewares = [])
    {
        $this->middlewares = array_map(static function (ResponseMiddlewareInterface $middleware) {
            return $middleware;
        }, $middlewares);
    }

    public function handle(ResponseInterface $response): ResponseInterface
    {
        if (count($this->middlewares) === 0) {
            return $response;
        }

        return array_shift($this->middlewares)?->handle($response, $this);
    }
}
