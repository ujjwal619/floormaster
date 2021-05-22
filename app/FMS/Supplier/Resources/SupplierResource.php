<?php

namespace App\FMS\Supplier\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SupplierResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'trading_name' => $this->trading_name,
            'site_id' => $this->site_id,
            'street' => $this->street,
            'phone' => $this->phone,
            'contact' => $this->contact,
            'fax' => $this->fax,
            'abn' => $this->abn,
            'code' => $this->code,
            'conduct' => $this->conduct,
            'suburb' => $this->suburb,
            'email' => $this->email,
            'state' => $this->state,
            'sales_detail' => json_decode($this->sales_detail),
            'product_list_url' => $this->product_list_url,
            'key_no' => $this->key_no,
            'early_discount' => json_decode($this->early_discount),
            'normal_discount' => json_decode($this->normal_discount),
            'bank' => json_decode($this->bank),
            'site' => [
                'id' => $this->site_id,
                'name' => $this->site_name
            ],
            'default_cost_account' => [
                'id' => $this->dca_id,
                'name' => $this->dca_name,
                'code' => $this->dca_code,
            ],
            'levy_account'  => [
                'id' => $this->la_id,
                'name' => $this->la_name,
                'code' => $this->la_code,
            ],
            'delivery' => $this->delivery,
            'central_billing'  => [
                'id' => $this->central_billing_id,
                'name' => $this->central_billing_name,
            ],
            'levy_percent' => $this->levy_percent,
            'products' => json_decode($this->products),
        ];
    }
}
