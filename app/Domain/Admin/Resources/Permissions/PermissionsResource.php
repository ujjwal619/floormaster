<?php

namespace App\Domain\Admin\Resources\Permissions;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PermissionsResource
 * @package App\Domain\Admin\Resources\Permissions
 */
class PermissionsResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $editDetails = route('admin.permissions.edit', $this);
        $deleteUrl   = route('admin.permissions.destroy', $this);

        return [
            'name'   => $this->name,
            'title'  => $this->title,
            'action' => [
                'edit'   => $editDetails,
                'delete' => [
                    'method'          => 'delete',
                    'url'             => $deleteUrl,
                    'title'           => 'Delete permission',
                    'icon'            => 'fa fa-trash',
                    'success_message' => 'Successfully deleted the permission.',
                ],
            ],
        ];
    }
}
