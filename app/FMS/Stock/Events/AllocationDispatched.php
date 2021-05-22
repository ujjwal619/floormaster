<?php

namespace App\FMS\Stock\Events;

use App\FMS\Stock\Models\Allocation;
use App\FMS\Stock\Models\AllocationDispatch;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;

class AllocationDispatched
{
    public $allocation;
    public $allocationDispatch;
    public $productCategory;
    public $futureStock;
    public $date;
    public $quantity;
    public $transactionJournalId;

    public function __construct(
        Allocation $allocation,
        AllocationDispatch $allocationDispatch,
        string $date,
        float $quantity,
        $transactionJournalId
    ) {
        $this->allocation = $allocation;
        $this->allocationDispatch = $allocationDispatch;
        $this->currentStock = $allocation->currentStock;
        $this->futureStock = $this->currentStock->futureStock;
        $this->productCategory = $allocation->color->product->category;
        $this->date = $date;
        $this->quantity = $quantity;
        $this->transactionJournalId = $transactionJournalId;
    }

    public function dispatchQuantity()
    {
        return $this->quantity;
    }

    public function getDate()
    {
        return $this->date ?? date('Y-m-d');
    }

    public function getTransactionJournalId()
    {
        return $this->transactionJournalId;
    }

    public function getCategory()
    {
        return $this->productCategory;
    }

    public function getAllocation()
    {
        return $this->allocation;
    }

    public function getAllocationDispatch()
    {
        return $this->allocationDispatch;
    }

    public function futureStockData()
    {
        $futureStockData = $this->futureStock->toArray();
        $futureStockData['quantity'] = $this->quantity;
        return $futureStockData;
    }

    public function isInvoiced()
    {
        return $this->currentStock->is_invoiced;
    }

    public function transactionJournalData($amount = 0)
    {
        $debitAccountId = $this->productCategory->cos_account_id;
        $creditAccountId = $this->productCategory->inventory_account_id;

        return [
            'transaction_type' => TransactionJournalType::INVENTORY,
            'debit_account_id' => $debitAccountId,
            'credit_account_id' => $creditAccountId,
            'site_id' => $this->allocation->site_id,
            'job_id' => $this->allocation->job_id,
            'debit_amount' => $amount,
            'credit_amount' => $amount,
            'name' => $this->allocation->client,
            'date' => $this->getDate(),
            'debit_operator' => '+',
            'credit_operator' => '-',
            'action' => 'allocation_dispatched',
            'allocation_id' => $this->allocation->id
        ];
    }
}
