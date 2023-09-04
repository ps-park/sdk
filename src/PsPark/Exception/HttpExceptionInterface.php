<?php

declare(strict_types=1);

namespace PsPark\Exception;

use PsPark\Request\ResponseInterface;

/**
 * Base interface for HTTP-related exceptions.
 */
interface HttpExceptionInterface extends ExceptionInterface
{
    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;
}
