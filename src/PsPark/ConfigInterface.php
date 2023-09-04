<?php

declare(strict_types=1);

namespace PsPark;

interface ConfigInterface
{
    public function getApiKey(): string;

    public function getJwtKey(): string;

    public function getCurlOptions(): array;
}
