<?php

declare(strict_types=1);

namespace PsPark\Exception;

/**
 * When a 5xx response is returned.
 */
interface ServerExceptionInterface extends HttpExceptionInterface
{
}
