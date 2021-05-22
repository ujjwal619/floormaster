<?php

namespace App\Data\Repositories\Stock;

use App\Data\Entities\Models\Stock\OrderReceipt;
use App\StartUp\BaseClasses\Repository\BaseRepository;

class OrderReceiptEloquentRepository extends BaseRepository implements OrderReceiptRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderReceipt::class;
    }
}
