<?php

declare(strict_types=1);

namespace PsPark\Storage;

use PsPark\Enum\ApiUrl;
use PsPark\Validator\ValidatorInterface;

interface StorageInterface
{
    public function add(ApiUrl $url, ValidatorInterface $validator): void;

    public function exists(ApiUrl $url): bool;

    public function get(ApiUrl $url): ?ValidatorInterface;
}
