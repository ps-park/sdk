<?php

declare(strict_types=1);

namespace PsPark\Handler;

use PsPark\Request\RequestInterface;

interface RequestHandlerInterface
{
    public function handle(RequestInterface $request): RequestInterface;
}
