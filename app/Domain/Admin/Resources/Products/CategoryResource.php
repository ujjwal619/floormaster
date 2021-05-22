<?php

namespace App\Domain\Admin\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string name
 * @property string title
 * @property string description
 */
class CategoryResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'       => $this->title,
            'description' => $this->description ?? 'N/A',
            'action'      => [
                'edit'   => [
                    'urls'        => [
                        'details' => route('admin.products.categories.details', $this),
                        'update'  => route('admin.products.categories.update', $this),
                    ],
                    'custom_edit' => true,
                ],
                'delete' => [
                    'method'          => 'delete',
                    'url'             => route('admin.products.categories.destroy', $this),
                    'title'           => 'Delete product',
                    'icon'            => 'fa fa-trash',
                    'success_message' => 'Successfully deleted product category.',
                ],
            ],
        ];
    }

}