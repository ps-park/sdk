<?php

declare(strict_types=1);

namespace PsPark\Enum;

enum ApiUrl: string
{
    case RATES = 'rates';
    case BALANCES = 'balances';
    case WALLET_BALANCE = 'wallet/:walletId/balance';
    case WALLET_ADDRESS_CREATE = 'wallet/:walletId/address/create';
    case WALLET_INVOICE_CREATE = 'wallet/:walletId/invoice/create';
    case WALLET_WITHDRAWAL_CREATE = 'wallet/:walletId/withdrawal/create';
    case TRANSACTION_STATUS = 'wallet/:walletId/transaction/status';

    case WALLET_ID_PARAM_NAME = 'walletId';
}
