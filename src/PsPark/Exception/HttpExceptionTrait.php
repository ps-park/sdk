<?php

declare(strict_types=1);

namespace PsPark\Exception;

use PsPark\Request\ResponseInterface;

trait HttpExceptionTrait
{
    /**
     * @param ResponseInterface $response
     */
    public function __construct(
        private readonly ResponseInterface $response,
    ) {
        $message = $response->getReasonPhrase();
        $code    = $response->getStatusCode();

        parent::__construct($message, $code);
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
