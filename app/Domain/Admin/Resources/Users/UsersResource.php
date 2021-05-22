<?php

namespace App\Domain\Admin\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UsersResource
 * @property object full_name
 * @property string email
 * @property string username
 * @property string status
 * @property string formatted_full_name
 * @package App\Domain\Admin\Resources\Users
 */
class UsersResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $userDetails = getUserDetailsForDeleteButton($this);

        $editDetails  = route('admin.users.edit', $this);
        $viewDetails  = route('admin.users.show', $this);
        $updateStatus = route('admin.users.change.status', [$this, $userDetails['change_action']]);

        return [
            'name'     => $this->formatted_full_name,
            'email'    => $this->email,
            'username' => $this->username,
            'status'   => $this->status,
            'role'     => $this->roles ? deSlugify($this->roles[0]->name) : 'Not Available',
            'action'   => [
                'view'   => $viewDetails,
                'edit'   => $editDetails,
                'delete' => [
                    'method'          => 'patch',
                    'url'             => $updateStatus,
                    'title'           => $userDetails['title'],
                    'icon'            => $userDetails['icon'],
                    'success_message' => $userDetails['success_message'],
                ],
            ],
        ];
    }

}