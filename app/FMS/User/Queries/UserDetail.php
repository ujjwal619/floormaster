<?php

namespace App\FMS\User\Queries;

use App\FMS\User\Models\User;

class UserDetail
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function fetch(string $userId)
    {
        return $this->user->newQuery()
            ->with(['sites', 'permissions'])
            ->where('auth_users.id', $userId)
            ->select(
                'auth_users.id',
                'auth_users.username'
            )
            ->first();
    }
}
