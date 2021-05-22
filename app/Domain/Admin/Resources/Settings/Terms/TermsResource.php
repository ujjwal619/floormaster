<?php

namespace App\Domain\Admin\Resources\Settings\Terms;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TermsResource
 * @property string name
 * @package App\Domain\Admin\Resources\Settings\Terms
 */
class TermsResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'   => $this->name,
            'action' => [
                'edit'   => route('admin.terms.edit', $this),
                'delete' => [
                    'method'          => 'delete',
                    'url'             => route('admin.terms.destroy', $this),
                    'title'           => 'Remove term',
                    'icon'            => 'fa fa-trash',
                    'success_message' => 'Successfully removed term.',
                ],
            ],
        ];
    }
}
