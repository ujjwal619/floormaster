<?php

namespace App\Domain\Admin\Resources\Products;

use App\Constants\General;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class LabourProductResource
 * @package App\Domain\Admin\Resources\Products
 */
class LabourProductResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $editDetails = route('admin.products.type.edit', [General::LABOUR, $this]);
        $deleteUrl   = route('admin.products.type.destroy', [General::LABOUR, $this]);
        $viewStock   = route('admin.products.stocks.index', [General::LABOUR, $this]);

        return [
            'name'      => ucwords($this->name),
            'unit_cost' => $this->unit_cost ?? 'N/A',
            'action'    => [
                'edit'   => $editDetails,
                'delete' => [
                    'method'          => 'delete',
                    'url'             => $deleteUrl,
                    'title'           => 'Delete Product',
                    'icon'            => 'fa fa-trash',
                    'success_message' => 'Successfully deleted the Product.',
                ],
                'other'  => [
                    'title' => 'View Stock',
                    'url' => $viewStock,
                    'icon' => 'fa fa-eye'
                ],
            ],
        ];
    }
}
