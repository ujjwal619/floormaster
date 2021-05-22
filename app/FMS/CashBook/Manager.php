<?php

namespace App\FMS\CashBook;

use App\FMS\CashBook\Models\CashBook;

class Manager
{
    private $cashBook;

    public function __construct(CashBook $cashBook)
    {
        $this->cashBook = $cashBook;
    }

    public function createCashBook(array $details)
    {
        $this->cashBook->fill($details)->save();

        return $this->cashBook;
    }

    public function findById(int $id)
    {
        return $this->cashBook->find($id);
    }
}
