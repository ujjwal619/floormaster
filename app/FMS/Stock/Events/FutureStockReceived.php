<?php

namespace App\FMS\Stock\Events;

use App\Data\Entities\Models\Product\Category;
use App\Data\Entities\Models\Stock\CurrentStock;
use App\Data\Entities\Models\Supplier\Supplier;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;

class FutureStockReceived
{
    public $currentStock;
    public $productCategory;
    public $supplier;
    public $site;

    public function __construct(
        CurrentStock $currentStock, 
        Category $productCategory, 
        Supplier $supplier
    ) {
        $this->currentStock = $currentStock->load(['futureStockReceiveGroup.transactionJournal']);
        $this->productCategory = $productCategory;
        $this->supplier = $supplier;
        $this->site = $supplier->site;
    }

    public function transactionJournal()
    {
        return $this->currentStock->futureStockReceiveGroup->transactionJournal;
    }

    public function transactionJournalData()
    {
        $debitAccountId = $this->productCategory->inventory_account_id;
        $creditAccountId = $this->site->trade_creditors_id;
        $amount = 0;

        return [
            'transaction_type' => TransactionJournalType::INVENTORY,
            'debit_account_id' => $debitAccountId,
            'credit_account_id' => $creditAccountId,
            'site_id' => $this->site->id,
            'debit_amount' => $amount,
            'credit_amount' => $amount,
            'name' => $this->supplier->trading_name,
            'date' => $this->currentStock->received_date,
            'future_stock_receive_group_id' => $this->currentStock->future_stock_receive_group_id,
            'debit_operator' => '+',
            'credit_operator' => '+',
            'action' => 'future_stock_received',
            'supplier_id' => $this->supplier->id,
        ];
    }
}
