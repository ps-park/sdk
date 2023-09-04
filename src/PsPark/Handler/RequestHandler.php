<?php

declare(strict_types=1);

namespace PsPark\Handler;

use PsPark\Request\RequestInterface;
use PsPark\Middleware\RequestMiddlewareInterface;

class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var RequestMiddlewareInterface[]
     */
    private array $middlewares;

    /**
     * @param RequestMiddlewareInterface[] $middlewares
     */
    public function __construct(array $middlewares = [])
    {
        $this->middlewares = array_map(static function (RequestMiddlewareInterface $middleware) {
            return $middleware;
        }, $middlewares);
    }

    public function handle(RequestInterface $request): RequestInterface
    {
        if (count($this->middlewares) === 0) {
            return $request;
        }

        return array_shift($this->middlewares)?->handle($request, $this);
    }
}
