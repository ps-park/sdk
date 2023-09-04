<?php

declare(strict_types=1);

namespace PsPark\Trait;

trait JwtIssuerTrait
{
    private function getIssuedAndExpirationTimes(): array
    {
        return [
            'iat' => $iat = time(),
            'exp' => $iat + 30,
        ];
    }
}
