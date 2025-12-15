<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH_ON_DELIVERY = 'cod';
    case BANK_TRANSFER    = 'bank_transfer';
    case E_WALLET         = 'ewallet';

    public function label(): string
    {
        return match ($this) {
            self::CASH_ON_DELIVERY => 'Bayar di Tempat',
            self::BANK_TRANSFER    => 'Transfer Bank',
            self::E_WALLET         => 'E-Wallet',
        };
    }
}
