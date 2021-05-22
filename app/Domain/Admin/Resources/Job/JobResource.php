<?php

namespace App\Domain\Admin\Resources\Job;

use App\Data\Entities\Models\Customer\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class JobResource
 * @property int      quote_id
 * @property Customer customer
 * @property string   project
 * @package App\Domain\Admin\Resources\Job
 */
class JobResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'quote_number' => $this->quote_id ?? 'N/A',
            'customer'     => $this->customer->trading_name,
            'project'      => $this->project,
            'action'       => [
                'edit'   => route('admin.jobs.edit', $this),
                'delete' => [
                    'method'          => 'delete',
                    'url'             => route('admin.jobs.destroy', $this),
                    'title'           => 'Remove job ?',
                    'icon'            => 'fa fa-trash',
                    'success_message' => 'Successfully deleted job.',
                ]
            ],
        ];
    }
}