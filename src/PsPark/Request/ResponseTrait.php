<?php

declare(strict_types=1);

namespace PsPark\Request;

use PsPark\Exception\ClientException;
use PsPark\Exception\RedirectionException;
use PsPark\Exception\ServerException;

trait ResponseTrait
{
    /**
     * @throws ServerException
     * @throws ClientException
     * @throws RedirectionException
     */
    private function checkStatusCode(): void
    {
        $code = $this->getStatusCode();

        if (500 <= $code) {
            throw new ServerException($this);
        }

        if (400 <= $code) {
            throw new ClientException($this);
        }

        if (300 <= $code) {
            throw new RedirectionException($this);
        }
    }
}
