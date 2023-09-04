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
use PsPark\Request\ResponseInterface;

interface ApiClientInterface
{
    public function getBalance(BalanceRequest $balanceDto): ResponseInterface;

    public function getBalances(BalancesRequest $balancesDto): ResponseInterface;

    public function createAddress(AddressRequest $addressRequest): ResponseInterface;

    public function createWithdrawal(WithdrawalRequest $withdrawalDto): ResponseInterface;

    public function createInvoice(InvoiceRequest $invoiceCreateDto): ResponseInterface;

    public function getTransactionStatus(TransactionRequest $transactionDto): ResponseInterface;

    public function getRates(RateRequest $rateDto): ResponseInterface;
}
