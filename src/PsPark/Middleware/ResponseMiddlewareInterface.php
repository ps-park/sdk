<?php

declare(strict_types=1);

namespace PsPark\Middleware;

use PsPark\Handler\ResponseHandlerInterface;
use PsPark\Request\ResponseInterface;

interface ResponseMiddlewareInterface
{
    public function handle(ResponseInterface $response, ResponseHandlerInterface $handler): ResponseInterface;
}
