<?php

namespace App\Domain\Admin\Resources\Roles;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RolesResource
 * @property string name
 * @property string title
 * @package App\Domain\Admin\Resources\Roles
 */
class RolesResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $editDetails = route('admin.roles.edit', $this);
        $deleteUrl   = route('admin.roles.destroy', $this);

        return [
            'name'   => $this->name,
            'title'  => $this->title,
            'action' => [
                'edit'   => $editDetails,
                'delete' => [
                    'method'          => 'delete',
                    'url'             => $deleteUrl,
                    'title'           => 'Delete role',
                    'icon'            => 'fa fa-trash',
                    'success_message' => 'Successfully deleted the role.',
                ],
            ],
        ];
    }
}
