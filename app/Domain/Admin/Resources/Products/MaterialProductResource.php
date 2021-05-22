<?php

namespace App\Domain\Admin\Resources\Products;

use App\Constants\General;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MaterialProductResource
 * @package App\Domain\Admin\Resources\Products
 */
class MaterialProductResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $editDetails = route('admin.products.type.edit', [General::MATERIAL, $this]);
        $deleteUrl   = route('admin.products.type.destroy', [General::MATERIAL, $this]);
        $viewStock   = route('admin.products.stocks.index', [General::MATERIAL, $this]);

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
