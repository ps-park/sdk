<?php

declare(strict_types=1);

namespace PsPark\Middleware;

use PsPark\Handler\RequestHandlerInterface;
use PsPark\Request\RequestInterface;

interface RequestMiddlewareInterface
{
    public function handle(RequestInterface $request, RequestHandlerInterface $handler): RequestInterface;
}
