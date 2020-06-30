<?php

namespace App\Services;

use App\Entity\PiggyBank;

class TransactionChecker
{
    public function isAllowed(PiggyBank $pb, string $type, float $amount): bool
    {
        if ($type == 'debit') {
            if ($pb->getBalance() - $amount < 0) {
                return false;
            }
        }

        if ($type == 'credit') {
            if ($pb->getBalance() + $amount > 1000) {
                return false;
            }
        }

        return true;
    }
}

