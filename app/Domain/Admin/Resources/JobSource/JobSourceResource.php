<?php

namespace App\Domain\Admin\Resources\JobSource;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class JobSourceResource
 * @package App\Domain\Admin\Resources\JobSource
 */
class JobSourceResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $editDetails = route('admin.job-sources.edit', $this);
        $deleteUrl   = route('admin.job-sources.destroy', $this);

        return [
            'title'  => $this->title,
            'name'   => $this->name,
            'action' => [
                'edit'   => $editDetails,
                'delete' => [
                    'method'          => 'delete',
                    'url'             => $deleteUrl,
                    'title'           => 'Delete job Source',
                    'icon'            => 'fa fa-trash',
                    'success_message' => 'Successfully deleted the Job Source.',
                ],
            ],
        ];
    }
}
