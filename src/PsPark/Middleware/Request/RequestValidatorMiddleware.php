<?php

declare(strict_types=1);

namespace PsPark\Middleware\Request;

use PsPark\Exception\RequestValidationException;
use PsPark\Handler\RequestHandlerInterface;
use PsPark\Middleware\RequestMiddlewareInterface;
use PsPark\Request\RequestInterface;
use PsPark\Storage\StorageInterface;

class RequestValidatorMiddleware implements RequestMiddlewareInterface
{
    public function __construct(
        private readonly StorageInterface $storage,
    ) {
    }

    public function handle(RequestInterface $request, RequestHandlerInterface $handler): RequestInterface
    {
        if ($this->storage->exists($request->getUrl())) {
            $validator = $this->storage->get($request->getUrl());

            if ($validator !== null) {
                $validator->validate($request);

                if ($validator->hasErrors()) {
                    throw new RequestValidationException(implode('; ', $validator->getErrors()));
                }
            }
        }

        return $handler->handle($request);
    }
}
