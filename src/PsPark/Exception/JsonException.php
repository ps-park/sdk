<?php

declare(strict_types=1);

namespace PsPark\Exception;

/**
 * Thrown by responses' asArray() method when their content cannot be JSON-decoded.
 */
class JsonException extends \RuntimeException implements DecodingExceptionInterface
{
}
