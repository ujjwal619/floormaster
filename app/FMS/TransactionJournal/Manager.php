<?php

namespace App\FMS\TransactionJournal;

use App\FMS\TransactionJournal\Models\TransactionJournal;

class Manager
{
    private $transactionJournal;

    public function __construct(TransactionJournal $transactionJournal)
    {
        $this->transactionJournal = $transactionJournal;
    }

    public function create(array $details)
    {
        $transactionJournal = $this->transactionJournal->newInstance();
        $this->save($transactionJournal, $details);
        return $transactionJournal;
    }

    public function all()
    {
        return $this->site->all();
    }

    public function update(TransactionJournal $transactionJournal, array $details)
    {
        return $this->save($transactionJournal, $details);
    }

    public function save(TransactionJournal $transactionJournal, array $details)
    {
        return $transactionJournal->fill($details)->save();
    }

    public function findById(int $id)
    {
        return $this->transactionJournal->find($id);
    }
}
