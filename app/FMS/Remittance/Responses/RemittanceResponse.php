<?php

namespace App\FMS\Remittance\Responses;

use Illuminate\Http\Resources\Json\Resource;

class RemittanceResponse extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'site_id' => $this->site_id,
            'remittance_number' => $this->remittance_number,
            'default_item_status' => $this->default_item_status,
            'payment_type' => $this->payment_type,
            'transaction_date' => $this->transaction_date,
            'cheque_date' => $this->cheque_date,
            'cheque_number' => $this->cheque_number,
            'invoice_date' => $this->invoice_date,
            'supplier_id' => $this->supplier_id,
//            'cheque_number' => $this->cheque_number,
//            'cheque_number' => $this->cheque_number,
        ];
    }
}
