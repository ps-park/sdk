<?php

declare(strict_types=1);

namespace PsPark\Exception;

final class ClientException extends \RuntimeException implements ClientExceptionInterface
{
    use HttpExceptionTrait;
}
