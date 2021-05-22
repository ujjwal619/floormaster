<?php

namespace App\Domain\Admin\Resources\Suppliers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed trading_name
 * @property mixed phone
 * @property mixed fax
 */
class SupplierResource extends JsonResource
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
                'view'   => route('admin.suppliers.show', $this),
                'edit'   => route('admin.suppliers.edit', $this),
                'delete' => [
                    'method'          => 'delete',
                    'url'             => route('admin.suppliers.destroy', $this),
                    'title'           => 'Delete Supplier',
                    'icon'            => 'fa fa-trash',
                    'success_message' => 'Successfully deleted Supplier.',
                ],
            ],
        ];
    }
}
