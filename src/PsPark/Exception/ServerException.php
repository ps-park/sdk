<?php

declare(strict_types=1);

namespace PsPark\Exception;

class ServerException extends \RuntimeException implements HttpExceptionInterface
{
    use HttpExceptionTrait;
}
