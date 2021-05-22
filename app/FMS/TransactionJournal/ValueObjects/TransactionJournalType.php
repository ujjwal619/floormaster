<?php

namespace App\FMS\TransactionJournal\ValueObjects;

class TransactionJournalType
{
    const GENERAL = 1;
    const PURCHASES = 2;
    const INVENTORY = 3;
    const SALES = 4;
    const RECEIPTS = 5;
    const DISBURSEMENTS = 6;

    public function all()
    {
        return [self::GENERAL, self::PURCHASES, self::INVENTORY, self::SALES, self::RECEIPTS, self::DISBURSEMENTS];
    }
}
