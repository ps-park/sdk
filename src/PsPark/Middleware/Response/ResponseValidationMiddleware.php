<?php

declare(strict_types=1);

namespace PsPark\Middleware\Response;

use PsPark\Exception\ResponseValidationException;
use PsPark\Handler\ResponseHandlerInterface;
use PsPark\Request\ResponseInterface;
use PsPark\Middleware\ResponseMiddlewareInterface;

class ResponseValidationMiddleware implements ResponseMiddlewareInterface
{
    public function handle(ResponseInterface $response, ResponseHandlerInterface $handler): ResponseInterface
    {
        $responseData = $response->asArray();

        if (!empty($responseData['code']) && (int) $responseData['code'] !== 0) {
            throw new ResponseValidationException($responseData['message'], (int) $responseData['code']);
        }

        return $handler->handle($response);
    }
}
