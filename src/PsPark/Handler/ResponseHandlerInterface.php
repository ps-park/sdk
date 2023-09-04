<?php

declare(strict_types=1);

namespace PsPark\Handler;

use PsPark\Request\ResponseInterface;

interface ResponseHandlerInterface
{
    public function handle(ResponseInterface $response): ResponseInterface;
}
