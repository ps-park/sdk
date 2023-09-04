<?php

declare(strict_types=1);

namespace PsPark\Factory;

use PsPark\ClientInterface;
use PsPark\ConfigInterface;
use PsPark\Enum\ApiUrl;
use PsPark\Handler\RequestHandler;
use PsPark\Handler\ResponseHandler;
use PsPark\Middleware\Request\RequestSignerMiddleware;
use PsPark\Middleware\Request\RequestValidatorMiddleware;
use PsPark\Middleware\Response\ResponseValidationMiddleware;
use PsPark\ProxyClient;
use PsPark\Storage\StorageInterface;
use PsPark\Storage\ValidatorStorage;
use PsPark\Transport\CurlTransport;
use PsPark\Validator\AddressCreateRequestValidator;
use PsPark\Validator\BalanceRequestValidator;
use PsPark\Validator\InvoiceCreateRequestValidator;
use PsPark\Validator\TransactionRequestValidator;
use PsPark\Validator\WithdrawalRequestValidator;

class ClientFactory implements ClientFactoryInterface
{
    public function __construct(
        private readonly ConfigInterface $requestConfig,
    ) {
    }

    public function create(): ClientInterface
    {
        return new ProxyClient(
            $this->createCurlTransport(),
            $this->getRequestHandler(),
            $this->getHandler()
        );
    }

    private function createCurlTransport(): CurlTransport
    {
        return new CurlTransport($this->requestConfig);
    }

    private function getRequestHandler(): RequestHandler
    {
        return new RequestHandler([
            new RequestValidatorMiddleware($this->createValidatorStorage()),
            new RequestSignerMiddleware(
                $this->requestConfig->getApiKey(),
                $this->requestConfig->getJwtKey()
            ),
        ]);
    }

    private function getHandler(): ResponseHandler
    {
        return new ResponseHandler([
            new ResponseValidationMiddleware(),
        ]);
    }

    private function createValidatorStorage(): StorageInterface
    {
        $validatorStorage = new ValidatorStorage();
        $validatorStorage->add(ApiUrl::BALANCES, new BalanceRequestValidator());
        $validatorStorage->add(ApiUrl::WALLET_BALANCE, new BalanceRequestValidator());
        $validatorStorage->add(ApiUrl::WALLET_ADDRESS_CREATE, new AddressCreateRequestValidator());
        $validatorStorage->add(ApiUrl::WALLET_INVOICE_CREATE, new InvoiceCreateRequestValidator());
        $validatorStorage->add(ApiUrl::WALLET_WITHDRAWAL_CREATE, new WithdrawalRequestValidator());
        $validatorStorage->add(ApiUrl::TRANSACTION_STATUS, new TransactionRequestValidator());

        return $validatorStorage;
    }
}
