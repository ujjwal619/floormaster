<?php

namespace App\Domain\Admin\Resources\Quotes;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed trading_name
 * @property mixed phone
 * @property mixed fax
 */
class QuotesResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'quote_number' => $this->quote_id,
            'customer'     => $this->customer->trading_name,
            'project'      => $this->project,
            'action'       => [
//                'view'   => route('admin.quotes.show', $this),
                'edit'   => route('admin.quotes.edit', $this),
                'delete' => [
                    'method'          => 'delete',
                    'url'             => route('admin.quotes.destroy', $this),
                    'title'           => 'Remove quote',
                    'icon'            => 'fa fa-trash',
                    'success_message' => 'Successfully removed quote.',
                ],
                'other' => [
                    'title' => 'Convert to jobs',
                    'url' => route('admin.quotes.to_job', $this),
                    'icon' => 'fa fa-refresh'
                ]
            ],
        ];
    }

}
