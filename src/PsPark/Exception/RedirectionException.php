<?php

declare(strict_types=1);

namespace PsPark\Exception;

class RedirectionException extends \RuntimeException implements HttpExceptionInterface
{
    use HttpExceptionTrait;
}
