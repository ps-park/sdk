<?php

declare(strict_types=1);

namespace PsPark;

use PsPark\Dto\AddressRequest;
use PsPark\Dto\BalanceRequest;
use PsPark\Dto\BalancesRequest;
use PsPark\Dto\InvoiceRequest;
use PsPark\Dto\RateRequest;
use PsPark\Dto\TransactionRequest;
use PsPark\Dto\WithdrawalRequest;
use PsPark\Enum\ApiUrl;
use PsPark\Exception\ClientExceptionInterface;
use PsPark\Factory\ClientFactory;
use PsPark\Request\ConfigurableHttpRequest;
use PsPark\Request\HttpRequest;
use PsPark\Request\RequestInterface;
use PsPark\Request\ResponseInterface;

final class PsPark implements ApiClientInterface
{
    private readonly ClientInterface $client;

    public function __construct(
        private readonly Config $config,
    ) {
        $this->client = (new ClientFactory($config))->create();
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getBalance(BalanceRequest $balanceDto): ResponseInterface
    {
        return $this->client->sendRequest(
            $this
                ->request()
                ->withUrl(ApiUrl::WALLET_BALANCE)
                ->addUrlParams(ApiUrl::WALLET_ID_PARAM_NAME->value, $balanceDto->walletId)
                ->withBody($balanceDto->asArray())
        );
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getBalances(BalancesRequest $balancesDto): ResponseInterface
    {
        return $this->client->sendRequest(
            $this
                ->request()
                ->withUrl(ApiUrl::BALANCES)
                ->withBody($balancesDto->asArray())
        );
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function createAddress(AddressRequest $addressRequest): ResponseInterface
    {
        return $this->client->sendRequest(
            $this
                ->request()
                ->withUrl(ApiUrl::WALLET_ADDRESS_CREATE)
                ->addUrlParams(ApiUrl::WALLET_ID_PARAM_NAME->value, $addressRequest->walletId)
                ->withBody($addressRequest->asArray())
        );
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function createWithdrawal(WithdrawalRequest $withdrawalDto): ResponseInterface
    {
        return $this->client->sendRequest(
            $this
                ->request()
                ->addUrlParams(ApiUrl::WALLET_ID_PARAM_NAME->value, $withdrawalDto->walletId)
                ->withUrl(ApiUrl::WALLET_WITHDRAWAL_CREATE)
                ->withBody($withdrawalDto->asArray())
        );
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function createInvoice(InvoiceRequest $invoiceCreateDto): ResponseInterface
    {
        return $this->client->sendRequest(
            $this
                ->request()
                ->withUrl(ApiUrl::WALLET_INVOICE_CREATE)
                ->addUrlParams(ApiUrl::WALLET_ID_PARAM_NAME->value, $invoiceCreateDto->walletId)
                ->withBody($invoiceCreateDto->asArray())
        );
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getTransactionStatus(TransactionRequest $transactionDto): ResponseInterface
    {
        return $this->client->sendRequest(
            $this
                ->request()
                ->withUrl(ApiUrl::TRANSACTION_STATUS)
                ->withBody($transactionDto->asArray())
        );
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getRates(RateRequest $rateDto): ResponseInterface
    {
        return $this->client->sendRequest(
            $this
                ->request()
                ->withUrl(ApiUrl::RATES)
                ->withBody($rateDto->asArray())
        );
    }

    private function request(): RequestInterface
    {
        return new ConfigurableHttpRequest(new HttpRequest(), $this->config);
    }
}
