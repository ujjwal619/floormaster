<?php

namespace App\Domain\Admin\Resources\Customers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed trading_name
 * @property mixed phone
 * @property mixed fax
 */
class CustomerResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'trading_name' => $this->trading_name,
            'phone'        => $this->phone,
            'fax'          => $this->fax,
            'action'       => [
                'view'   => route('admin.customers.show', $this),
                'edit'   => route('admin.customers.edit', $this),
                'delete' => [
                    'method'          => 'delete',
                    'url'             => route('admin.customers.destroy', $this),
                    'title'           => 'Delete Customer',
                    'icon'            => 'fa fa-trash',
                    'success_message' => 'Successfully deleted customer.',
                ],
                'other'  => [
                    'url'   => route('admin.quotes.create', $this),
                    'title' => 'Add quotation',
                    'icon'  => 'fa fa-plus',
                ],
            ],
        ];
    }

}
