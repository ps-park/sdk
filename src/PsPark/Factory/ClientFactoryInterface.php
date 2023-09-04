<?php

declare(strict_types=1);

namespace PsPark\Factory;

use PsPark\ClientInterface;

interface ClientFactoryInterface
{
    public function create(): ClientInterface;
}
