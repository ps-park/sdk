<?php

declare(strict_types=1);

namespace PsPark\Storage;

use Countable;
use PsPark\Enum\ApiUrl;
use PsPark\Validator\ValidatorInterface;
use SplObjectStorage;

class ValidatorStorage implements StorageInterface, Countable
{
    public function __construct(
        private readonly SplObjectStorage $validatorList = new SplObjectStorage()
    ) {
    }

    public function count(): int
    {
        return count($this->validatorList);
    }

    public function add(ApiUrl $url, ValidatorInterface $validator): void
    {
        $this->validatorList->attach($url, $validator);
    }

    public function exists(ApiUrl $url): bool
    {
        return $this->validatorList->contains($url);
    }

    public function get(ApiUrl $url): ?ValidatorInterface
    {
        if (!$this->validatorList->contains($url)) {
            return null;
        }

        return $this->validatorList->offsetGet($url);
    }
}
