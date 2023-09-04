<?php

declare(strict_types=1);

namespace PsPark\Enum;

enum ApiVersion: string
{
    case V1 = 'v1';

    public static function getDefault(): self
    {
        return self::V1;
    }
}
