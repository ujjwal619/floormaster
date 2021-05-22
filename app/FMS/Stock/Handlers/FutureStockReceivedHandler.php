<?php

namespace App\FMS\Stock\Handlers;

use App\FMS\Stock\Events\FutureStockReceived;
use App\FMS\TransactionJournal\Manager;

class FutureStockReceivedHandler
{
    private $transactionJournalManager;

    public function __construct(
        Manager $transactionJournalManager
    ) {
        $this->transactionJournalManager = $transactionJournalManager;
    }

    public function handle(FutureStockReceived $futureStockReceived)
    {
        $transactionJournal = $futureStockReceived->transactionJournal();
        
        if (!$transactionJournal) {
            $this->transactionJournalManager->create($futureStockReceived->transactionJournalData());
        }

    }
}
